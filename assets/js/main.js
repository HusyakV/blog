// Lozad
const observer = lozad();
observer.observe();
// Lozad

// Menu
menu = document.querySelector(".menu-wrapper");
menu.addEventListener("mouseover", () => {
  menu.classList.add("active");
});
menu.addEventListener("click", () => {
  if (menu.classList.contains("active")) {
    menu.classList.remove("active");
  } else {
    menu.classList.add("active");
  }
});
menu.addEventListener("mouseout", () => {
  menu.classList.remove("active");
});
// Menu
// Send form
let submit = document.querySelector(".send-form");
let form = document.querySelector(".form");
let input = document.querySelectorAll(".input");
let comment_send = document.querySelector(".banner-content");
let bannerTitle = document.querySelector(".banner-title");
let bannerSubtitle = document.querySelector(".banner-subtitle");
let hand = document.querySelector(".hand");

function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

submit.addEventListener("click", function (e) {
  e.preventDefault();

  let error = false;

  if (!isValidEmail(input[0].value)) {
    error = true;
    form.classList.add("error");
  } else {
    form.classList.remove("error");
  }

  if (!error) {
    let data = new FormData(form);
    fetch("/wp-content/themes/aqva/send.php", {
      method: "POST",
      body: data,
    }).then((data) => {
      if (data.ok == true) {
        form.reset();
        comment_send.classList.add("active");
        bannerTitle.innerHTML = "Thanks for subscribing <br>to our newsletter!";
        bannerSubtitle.textContent =
          "You will be the first to know about our news";
        hand.style.backgroundImage =
          "url(/wp-content/themes/aqva/assets/img/svg/hand-ok.svg)";
        form.style.display = "none";
      }
    });
  }
});

// Send form
document.addEventListener("DOMContentLoaded", function () {
  const categoryButtons = document.querySelectorAll(".filter-button");

  categoryButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      categoryButtons.forEach(function (btn) {
        btn.classList.remove("active");
      });

      this.classList.add("active");

      var category = this.getAttribute("data-category");

      var data = new FormData();
      data.append("action", "filter_posts");
      data.append("category", category);

      fetch(ajax_obj.ajax_url, {
        method: "POST",
        body: data,
      })
        .then(function (response) {
          return response.text();
        })
        .then(function (html) {
          document.querySelector(".archive-post").innerHTML = html;
        });
    });
  });
});

let Visible = function (target) {
  if (target !== null) {
    let targetPosition = {
        top: window.pageYOffset + target.getBoundingClientRect().top,
        left: window.pageXOffset + target.getBoundingClientRect().left,
        right: window.pageXOffset + target.getBoundingClientRect().right,
        bottom: window.pageYOffset + target.getBoundingClientRect().bottom,
      },
      windowPosition = {
        top: window.pageYOffset,
        left: window.pageXOffset,
        right: window.pageXOffset + document.documentElement.clientWidth,
        bottom: window.pageYOffset + document.documentElement.clientHeight,
      };

    if (
      targetPosition.top < windowPosition.bottom &&
      targetPosition.right > windowPosition.left &&
      targetPosition.left < windowPosition.right
    ) {
      if (target.classList.contains("active") == false) {
        target.classList.add("active");
      }
    }
  }
};

function viewCheckAll(a) {
  if (a !== null) {
    window.addEventListener("scroll", function () {
      for (let i = 0; i < document.querySelectorAll(a).length; i++) {
        Visible(document.querySelectorAll(a)[i]);
      }
    });
  }
}
viewCheckAll(".archive .archive-post__item");
window.addEventListener("scroll", function () {
  Visible(document.querySelector(".archive .archive-post__item"));
});
