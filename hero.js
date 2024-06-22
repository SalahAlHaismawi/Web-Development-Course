const linksList = document.querySelector(".links-list");
const mobileNavToggle = document.querySelector(".mobile-nav-toggle");
const mobileNav = document.querySelector(".mobile-nav ");
const closeMobileNav = document.querySelector(".exit-mobile-menu");
const navigation = document.querySelector(".nav");

const sizeChanged = () => {
    let windowSize = window.innerWidth;

    if(windowSize <= 800) {
        linksList.style = "display: none";
        mobileNavToggle.style = "display: block";
        navigation.setAttribute('data-aos', '')
    }else{
        linksList.style = "display: flex";
        mobileNavToggle.style = "display: none";
        navigation.setAttribute('data-aos', 'fade-down')
    }
};

sizeChanged()

window.onresize = sizeChanged;

mobileNavToggle.addEventListener('click', () => {
    mobileNav.style = "transform: translateX(0)";
});

closeMobileNav.addEventListener('click', () => {
    mobileNav.style = "transform: translateX(100%)";
});