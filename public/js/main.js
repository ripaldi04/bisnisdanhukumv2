// Accordion funtion
document.addEventListener('DOMContentLoaded', function() {
    const accordionBtns = document.querySelectorAll('.accordion-button');
    
    accordionBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        const targetId = this.dataset.accordion;
        const targetAccordion = document.getElementById(targetId);
  
        btn.classList.toggle('open');
        targetAccordion.classList.toggle('hide');

        if (targetAccordion.classList.contains('hide')) {
            targetAccordion.style.maxHeight = "0";
            } else {
            targetAccordion.style.maxHeight = targetAccordion.scrollHeight + "px";
            }
        });
    });
});

function updateFileName(input) {
    if (input.files && input.files.length > 0) {
        // Get the file name
        var fileName = input.files[0].name;
        
        // Update the text of the <p> element inside the button
        document.getElementById('fileLabel').innerText = fileName;
    }
}