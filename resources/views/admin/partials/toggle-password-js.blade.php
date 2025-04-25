{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- jQuery & Bootstrap --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- Toggle Password --}}
<script>
    $(document).ready(function () {
        function togglePassword(inputId, iconId) {
            const input = $("#" + inputId);
            const icon = $("#" + iconId);

            if (input.attr("type") === "password") {
                input.attr("type", "text");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            } else {
                input.attr("type", "password");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            }
        }

        $("#togglePassword").on("click", function () {
            togglePassword("password", "eyeIcon");
        });

        $("#toggleConfirmPassword").on("click", function () {
            togglePassword("password_confirmation", "confirmEyeIcon");
        });
    });
</script>
