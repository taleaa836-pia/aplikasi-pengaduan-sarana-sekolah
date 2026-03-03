document.addEventListener('DOMContentLoaded', function() {
    // Image preview logic
    const inputImage = document.querySelector('input[name="gambar"]');
    if (inputImage) {
        inputImage.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                let preview = document.getElementById('image-preview');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.id = 'image-preview';
                    preview.className = 'img-fluid mt-2 rounded shadow-sm';
                    preview.style.maxHeight = '200px';
                    this.parentNode.appendChild(preview);
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }
});
