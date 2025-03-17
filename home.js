window.addEventListener('scroll', function() {
	const navLinks = document.querySelectorAll('.nav-link');
	const sections = document.querySelectorAll('section');
	let currentSectionIndex = 0;
	
	for (let i = 0; i < sections.length; i++) {
		if (window.pageYOffset >= sections[i].offsetTop - 50) {
			currentSectionIndex = i;
		}
	}
	
	navLinks.forEach(link => link.classList.remove('active'));
	navLinks[currentSectionIndex].classList.add('active');
});
var textWrapper = document.querySelector('.ml2');
textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

anime.timeline({loop: true})
  .add({
    targets: '.ml2 .letter',
    scale: [4,1],
    opacity: [0,1],
    translateZ: 0,
    easing: "easeOutExpo",
    duration: 950,
    delay: (el, i) => 70*i
  }).add({
    targets: '.ml2',
    opacity: 0,
    duration: 1000,
    easing: "easeOutExpo",
    delay: 1000
  });