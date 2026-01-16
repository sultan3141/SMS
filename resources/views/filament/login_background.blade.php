<style>
    body {
        background-image: url("{{ asset('login-bg.png') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
    .fi-simple-main {
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
    }
    .dark .fi-simple-main {
        background-color: rgba(24, 24, 27, 0.85); /* Zinc-900 with opacity */
    }
    /* Enhance logo visibility */
    .fi-logo {
        filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
    }
</style>
