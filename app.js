/* ============================================================
   SDLC Project – shared vanilla JS utilities
   ============================================================ */

/* 1. Show / hide password toggle
   Usage: <button type="button" class="pw-toggle" onclick="togglePw('inputId', this)">
   ----------------------------------------------------------------- */
function togglePw(inputId, btn) {
  var input = document.getElementById(inputId);
  if (!input) return;
  var show = input.type === "password";
  input.type = show ? "text" : "password";
  btn.innerHTML = show
    ? '<svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>'
    : '<svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>';
  btn.title = show ? "Ẩn mật khẩu" : "Hiện mật khẩu";
}

/* 2. Auto-dismiss success messages after 4 s
   ----------------------------------------------------------------- */
document.addEventListener("DOMContentLoaded", function () {
  var okMsg = document.querySelector(".msg.ok");
  if (okMsg) {
    setTimeout(function () {
      okMsg.style.transition = "opacity 0.5s";
      okMsg.style.opacity = "0";
      setTimeout(function () { if (okMsg.parentNode) okMsg.parentNode.removeChild(okMsg); }, 500);
    }, 4000);
  }
});

/* 3. Custom confirm modal
   Usage: onclick="return confirmAction('url', 'Title', 'Message text')"
   HTML required in the page:
     <div id="confirm-modal" class="modal-overlay"> … </div>
   ----------------------------------------------------------------- */
function confirmAction(href, title, msg) {
  var modal = document.getElementById("confirm-modal");
  if (!modal) { return window.confirm(msg || "Bạn có chắc chắn không?"); }

  var elTitle = document.getElementById("confirm-title");
  var elMsg   = document.getElementById("confirm-msg");
  var elOk    = document.getElementById("confirm-ok");

  if (elTitle) elTitle.textContent = title || "Xác nhận";
  if (elMsg)   elMsg.textContent   = msg   || "Hành động này không thể hoàn tác.";
  if (elOk)    elOk.href           = href;

  modal.classList.add("show");
  return false;
}

function closeModal() {
  var modal = document.getElementById("confirm-modal");
  if (modal) modal.classList.remove("show");
}

document.addEventListener("DOMContentLoaded", function () {
  var overlay = document.getElementById("confirm-modal");
  if (overlay) {
    overlay.addEventListener("click", function (e) {
      if (e.target === overlay) closeModal();
    });
  }
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") closeModal();
  });
});

/* 4. Password strength indicator
   Usage: <input oninput="checkPwStrength(this.value)">
          <div class="pw-strength"> … </div>
   ----------------------------------------------------------------- */
function checkPwStrength(val) {
  var bars  = document.querySelectorAll(".pw-strength-bar");
  var label = document.querySelector(".pw-strength-label");
  if (!bars.length || !label) return;

  var score = 0;
  if (val.length >= 8)           score++;
  if (/[A-Z]/.test(val))         score++;
  if (/[0-9]/.test(val))         score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;

  var levels = ["", "weak", "fair", "good", "strong"];
  var labels = ["", "Yếu", "Trung bình", "Khá", "Mạnh"];

  bars.forEach(function (bar, i) {
    bar.className = "pw-strength-bar";
    if (i < score) bar.classList.add("active", levels[score]);
  });

  label.className = "pw-strength-label";
  if (val.length > 0) {
    label.classList.add(levels[score]);
    label.textContent = labels[score];
  } else {
    label.textContent = "";
  }
}

/* 5. Inline confirm-password match validation
   Usage: <input id="confirm" oninput="checkConfirm()">
          <span id="confirm-hint" class="field-hint"></span>
   ----------------------------------------------------------------- */
function checkConfirm() {
  var pw      = document.getElementById("password");
  var confirm = document.getElementById("confirm");
  var hint    = document.getElementById("confirm-hint");
  if (!pw || !confirm || !hint) return;

  if (confirm.value === "") {
    hint.textContent = "";
    hint.className   = "field-hint";
    confirm.classList.remove("error-field");
  } else if (confirm.value === pw.value) {
    hint.textContent = "✓ Mật khẩu khớp";
    hint.className   = "field-hint ok";
    confirm.classList.remove("error-field");
  } else {
    hint.textContent = "✗ Mật khẩu không khớp";
    hint.className   = "field-hint error";
    confirm.classList.add("error-field");
  }
}
