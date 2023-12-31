// login 
const loginBtn = document.querySelector('.login-select');
const loginModal = document.querySelector('.login-modal')
const closeModal = document.querySelector('.modal-close')
const userTitle = document.querySelector('.user-title');
const spanContent = userTitle.innerText;

function showLogin (){
    loginModal.classList.add('visible');
};
function closeLogin (){
    loginModal.classList.remove('visible');
};

if (spanContent === 'Tài khoản') {
    loginBtn.addEventListener('click', showLogin);
}
closeModal.addEventListener('click', closeLogin);

// sign in
const signInBtn = document.querySelector('.sign-in');
const signInModal = document.querySelector('.signin-modal')
const closeSignInModal = document.querySelector('.modal-signin-close')
function showSignIn (){
    signInModal.classList.add('visible');
    loginModal.classList.remove('visible'); 
};
function closeSignIn (){
    signInModal.classList.remove('visible');
};

signInBtn.addEventListener('click', showSignIn);
closeSignInModal.addEventListener('click', closeSignIn);

// cart shopping
const cartBtn = document.querySelector('.cart-icon');
const cartModal = document.querySelector('.cart-wrapper');
const cartModal2 = document.querySelector('.block-cart');
const addToCartButtons = document.querySelectorAll('.add-to-card');

const cartClose = document.querySelector('.cart-close');
const exitCart = document.querySelector('.exit-cart');

function showCart (){
    cartModal.classList.add('cart-active');
    cartModal2.classList.add('cart-active');
};
function closeCart (){
    cartModal.classList.remove('cart-active');
    cartModal2.classList.remove('cart-active');
};

addToCartButtons.forEach(button => {
    button.addEventListener('click', showCart);
});

cartBtn.addEventListener('click', showCart);

exitCart.addEventListener('click', closeCart);
cartClose.addEventListener('click', closeCart);

// //cart increment - decrement 

const inputQtyElements = document.querySelectorAll('.input-qty');

// Add click event listeners to all elements with the class 'plus-qty'
document.querySelectorAll('.plus-qty').forEach((plusQty, index) => {
  plusQty.addEventListener('click', () => {
    // Get the value of the corresponding input element
    let num = parseInt(inputQtyElements[index].value);
    
    // Increment the value
    num++;

    // Update the input value directly
    inputQtyElements[index].value = num;
  });
});

// Add click event listeners to all elements with the class 'minus-qty'
document.querySelectorAll('.minus-qty').forEach((minusQty, index) => {
  minusQty.addEventListener('click', () => {
    // Get the value of the corresponding input element
    let num = parseInt(inputQtyElements[index].value);

    // Check if the value is greater than 1 before decrementing
    if (num > 1) {
      // Decrement the value
      num--;

      // Update the input value directly
      inputQtyElements[index].value = num;
    }
  });
});

// slider
let list = document.querySelector('.slider .list-slider');
let items = document.querySelectorAll('.slider .list-slider .item-slider');
let dots =  document.querySelectorAll('.slider .dots-slider li');
let leftBtn = document.getElementById('btns-slider-left');
let rightBtn = document.getElementById('btns-slider-right');

let active = 0;
let lenghtItems = items.length - 1;

rightBtn.onclick = function () {
    if (active + 1 > lenghtItems) {
        active = 0;
    }else {
        active ++;
    }
    reloadSlider();
}

let refreshSlider = setInterval(()=> {rightBtn.click()},5000);

leftBtn.onclick = function () {
    if (active - 1 < 0) {
        active = lenghtItems;
    }else {
        active--;
    }
    reloadSlider();
}
function reloadSlider() {
    let checkLeft = items[active].offsetLeft;
    list.style.left = -checkLeft + 'px';

    let lastActiveDot = document.querySelector('.slider .dots-slider li.active');
    lastActiveDot.classList.remove('active');
    dots[active].classList.add('active');

    clearInterval(refreshSlider);
    refreshSlider = setInterval(()=> {rightBtn.click()},5000);
}

document.querySelectorAll(".nav-item").forEach(function (element) {
    element.addEventListener("click", function () {
        document.querySelectorAll(".nav-item").forEach(function (el) {
            el.classList.remove("active-blocktitle");
        });

        element.classList.add("active-blocktitle");
    });
});

// slick slider
$(document).ready(function () {
    $(".image-slider").slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        arrows: true,
        draggable: false,
        prevArrow: `<button type='button' class='slick-prev slick-arrow'><i id="arrow-left" class="fa-solid fa-arrow-left"></i></button>`,
        nextArrow: `<button type='button' class='slick-next slick-arrow'><i id="arrow-left" class="fa-solid fa-arrow-right"></i></button>`,
        dots: false,
        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3,
                    draggable: true,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    arrows: false,
                    infinite: true,
                    draggable: true,
                },
            },
        ],
        // autoplay: true,
        // autoplaySpeed: 1000,
    });
});


