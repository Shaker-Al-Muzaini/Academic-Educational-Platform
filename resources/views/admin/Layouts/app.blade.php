<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{setting('app_name')}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="hold-transition sidebar-mini">
<div id="app"></div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleMenuIcon = document.getElementById('toggleMenuIcon');
        const body = document.querySelector('body');

        toggleMenuIcon.addEventListener('click', () => {
            if (body.classList.contains('sidebar-collapse')) {
                localStorage.setItem('sidebarState', 'expanded');
            } else {
                localStorage.setItem('sidebarState', 'collapsed');
            }
        });

        const sidebarState = localStorage.getItem('sidebarState');
        if (sidebarState === 'collapsed') {
            body.classList.add('sidebar-collapse');
        }
    });
</script>
</body>

</html>

