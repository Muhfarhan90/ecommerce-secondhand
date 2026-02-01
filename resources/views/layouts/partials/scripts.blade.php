{{-- Vite JS --}}
@vite('resources/js/app.js')

{{-- Alpine.js for interactivity --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

{{-- Global JavaScript --}}
<script>
    // Toast notification system
    window.showToast = function(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white transform translate-x-full transition-transform duration-300 z-50 ${
            type === 'success' ? 'bg-green-500' :
            type === 'error' ? 'bg-red-500' :
            type === 'warning' ? 'bg-yellow-500' :
            'bg-blue-500'
        }`;
        toast.textContent = message;
        document.body.appendChild(toast);

        // Slide in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);

        // Slide out and remove
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    };

    // Image lazy loading
    document.addEventListener('DOMContentLoaded', function() {
        const lazyImages = document.querySelectorAll('img[data-src]');

        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        });

        lazyImages.forEach(img => imageObserver.observe(img));
    });

    // Format currency
    window.formatCurrency = function(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(amount);
    };

    // Smooth scroll to top
    window.scrollToTop = function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };

    // Show scroll to top button
    window.addEventListener('scroll', function() {
        const scrollBtn = document.getElementById('scroll-to-top');
        if (scrollBtn) {
            if (window.pageYOffset > 300) {
                scrollBtn.classList.remove('hidden');
            } else {
                scrollBtn.classList.add('hidden');
            }
        }
    });
</script>

{{-- Scroll to Top Button --}}
<button id="scroll-to-top" onclick="scrollToTop()"
    class="hidden fixed bottom-6 right-6 w-12 h-12 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg hover:shadow-xl transition-all z-40 flex items-center justify-center group"
    aria-label="Scroll to top">
    <svg class="w-5 h-5 transform group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
    </svg>
</button>

{{-- Flash Messages --}}
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('success') }}', 'success');
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('error') }}', 'error');
        });
    </script>
@endif

@if (session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('warning') }}', 'warning');
        });
    </script>
@endif

@if (session('info'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showToast('{{ session('info') }}', 'info');
        });
    </script>
@endif

{{-- Page Specific Scripts --}}
@stack('scripts')
