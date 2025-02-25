<x-mail::message>

<x-mail::panel>
    <img src="{{ asset('./images/logoWA.svg') }}" alt="CHAMPIONHUB SUPPORT" style="max-width: 200px; display: block; margin: 0 auto;">
</x-mail::panel>

# 🔒 Đặt lại mật khẩu

**Xin chào,**

Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Nhấn vào nút bên dưới để thiết lập lại mật khẩu:

<x-mail::button :url="$actionUrl" color="primary">
🔑 Đặt lại mật khẩu
</x-mail::button>

⏳ *Liên kết này sẽ hết hạn sau* **{{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} phút**.

Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này. Tài khoản của bạn vẫn an toàn. 🛡️

---

**Trân trọng,**  
CHAMPIONHUB SUPPORT

<x-slot:subcopy>
Nếu bạn gặp khó khăn khi nhấp vào nút **"Đặt lại mật khẩu"**, vui lòng sao chép và dán đường dẫn bên dưới vào trình duyệt của bạn:

🔗 <span class="break-all">[{{ $actionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>

</x-mail::message>
