<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tournament;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        // Kiểm tra xác thực tài khoản qua email
        $user = User::where('email', $request->email)->first();
        if ($user && !$user->email_verified_at) {
            return back()->withErrors(['email' => 'Vui lòng xác thực email trước khi đăng nhập.'])->withInput();
        }

        // Lấy thông tin đăng nhập
        $credentials = $request->only('email', 'password');

        // Kiểm tra thông tin đăng nhập
        if (Auth::attempt($credentials)) {
            // Tạo lại session để tránh tấn công session fixation
            $request->session()->regenerate();
            // Chuyển hướng đến trang chính hoặc trang mong muốn
            return redirect()->intended('/');
        }

        // Trả về thông báo lỗi nếu đăng nhập thất bại
        return view('auth.login')->withErrors(['email' => 'Thông tin đăng nhập không chính xác. Vui lòng kiểm tra lại email và mật khẩu.']);
    }

    //Xử lý xác thực email
    function verifyEmail($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Mã xác thực không hợp lệ hoặc đã hết hạn.');
        }

        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Xác thực email thành công! Bạn có thể đăng nhập ngay.');
    }

    // Hiển thị form đăng ký tài khoản
    public function showRegisterForm()
    {
        return view('auth.signin');
    }

    // Xử lý đăng ký tài khoản mới
    public function register(Request $request)
    {
        // Xác thực dữ liệu nhập từ form đăng ký
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'name.max' => 'Họ tên không được vượt quá 255 ký tự.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại. Vui lòng sử dụng email khác.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        // Tạo người dùng mới trong database
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Mã hóa mật khẩu            
            'email_verified_at' => null,
            'verification_token' => Str::random(40),
        ]);

        // Gửi email xác thực
        Mail::send('auth.email', ['user' => $user], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject("Xác thực email của bạn");
        });
        // Trả về view đăng ký với thông báo thành công
        return redirect()->route('signin')->with('success', 'Đăng ký thành công. Vui lòng kiểm tra email để xác nhận tài khoản.');
    }

    // Xử lý đăng xuất người dùng
    public function logout(Request $request)
    {
        // Đăng xuất người dùng hiện tại
        Auth::logout();

        // Hủy session hiện tại
        $request->session()->invalidate();
        // Tạo lại CSRF token để tăng cường bảo mật
        $request->session()->regenerateToken();

        // Chuyển hướng đến trang chủ
        return redirect('/');
    }

    // Hiển thị trang thông tin cá nhân của người dùng
    public function profile()
    {
        // Lấy thông tin người dùng đang đăng nhập
        $user = Auth::user();
        // Lấy danh sách các giải đấu mà người dùng đã tạo
        $tournaments = Tournament::where('user_id', $user->id)->get();
        // Lấy danh sách các đội mà người dùng đã tạo
        $teams = Team::where('user_id', $user->id)->get();

        // Trả về view hiển thị thông tin cá nhân của người dùng
        return view('user.index', compact('user', 'tournaments', 'teams'));
    }

    // Hiển thị form quên mật khẩu
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Xử lý gửi email đặt lại mật khẩu
    public function sendResetLinkEmail(Request $request)
    {
        // Xác thực email
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.'
        ]);

        // Gửi liên kết đặt lại mật khẩu
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Kiểm tra trạng thái gửi email
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => 'Đường dẫn đặt lại mật khẩu đã được gửi đến email của bạn!'])
            : back()->withErrors(['email' => 'Không thể gửi email đặt lại mật khẩu. Vui lòng kiểm tra lại email.']);
    }

    // Hiển thị form đặt lại mật khẩu
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Xử lý đặt lại mật khẩu mới
    public function resetPassword(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'token.required' => 'Thiếu mã token đặt lại mật khẩu.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        // Đặt lại mật khẩu cho người dùng
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Cập nhật mật khẩu mới và tạo token mới
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        // Chuyển hướng đến trang đăng nhập nếu thành công, nếu không hiển thị lỗi
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Đặt lại mật khẩu thành công! Bạn có thể đăng nhập ngay.')
            : back()->withErrors(['email' => 'Đặt lại mật khẩu thất bại. Vui lòng thử lại sau.']);
    }
}
