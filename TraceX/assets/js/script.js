// TraceX uses JavaScript only for small client-side interactions.

const password = document.getElementById("password");
const passwordHint = document.getElementById("passwordHint");

if (password && passwordHint) {
    password.addEventListener("input", function () {
        if (password.value.length === 0) {
            passwordHint.textContent = "";
        } else if (password.value.length < 6) {
            passwordHint.textContent = "Use at least 6 characters.";
            passwordHint.className = "hint warning";
        } else {
            passwordHint.textContent = "Password length looks good.";
            passwordHint.className = "hint good";
        }
    });
}

const investigationForm = document.getElementById("investigationForm");

if (investigationForm) {
    investigationForm.addEventListener("submit", function () {
        const button = investigationForm.querySelector("button");
        if (button) {
            button.textContent = "Analyzing evidence...";
            button.disabled = true;
        }
    });
}

const fileInput = document.querySelector('input[type="file"]');

if (fileInput) {
    fileInput.addEventListener("change", function () {
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            if (file.size > 2 * 1024 * 1024) {
                alert("File is larger than 2 MB.");
                fileInput.value = "";
            }
        }
    });
}