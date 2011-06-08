    <div class="footer">&copy; Glucial Inc. All rights reserved.</div>
</body>
{if $is_login == 'y'}
    <script type='text/javascript'>
        setInterval(ping_server({$uid}), 30000);
    </script>
{/if}
</html>
