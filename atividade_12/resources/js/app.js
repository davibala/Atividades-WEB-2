import './bootstrap';
// document.getElementById('img_link').addEventListener('change', function(e) {
//     const file = e.target.files[0];
//     const preview = document.getElementById('preview-img');
    
//     if (file) {
//         const reader = new FileReader();
        
//         reader.onload = function(e) {
//             preview.style.width = '200px';
//             preview.style.height = '300px';

//             preview.src = e.target.result;
//             preview.classList.remove('d-none');
//         }
        
//         reader.readAsDataURL(file);
//     } else {
//         preview.classList.add('d-none');
//         preview.src = '#';
//     }
// });