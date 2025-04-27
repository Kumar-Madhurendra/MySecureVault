document.addEventListener('DOMContentLoaded', function() {
    // Theme icons
    const sunIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="sun-icon"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>`;
    const moonIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="moon-icon"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>`;
    
    // Get theme toggle button
    const themeToggle = document.getElementById('themeToggle');
    if (!themeToggle) return; // Exit if theme toggle doesn't exist
    
    // Apply saved theme or default to light-mode
    const savedTheme = localStorage.getItem('theme') || 'light-mode';
    setTheme(savedTheme);
    
    // Set up toggle button click handler
    themeToggle.addEventListener('click', function() {
        const currentTheme = document.body.classList.contains('dark-mode') ? 'dark-mode' : 'light-mode';
        const newTheme = currentTheme === 'dark-mode' ? 'light-mode' : 'dark-mode';
        setTheme(newTheme);
    });
    
    // Function to set theme and update UI
    function setTheme(theme) {
        // Make sure only one theme class is active
        document.body.classList.remove('light-mode', 'dark-mode');
        document.body.classList.add(theme);
        
        // Save theme preference
        localStorage.setItem('theme', theme);
        
        // Update toggle button icon
        themeToggle.innerHTML = theme === 'dark-mode' ? sunIcon : moonIcon;
        
        // Log for debugging
        console.log('Theme set to:', theme);
    }
}); 