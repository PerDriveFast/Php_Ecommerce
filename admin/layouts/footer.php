</div>
</div>

<script src="<?php echo BASE_URL; ?>dist_admin/js/scripts.js"></script>
<script src="<?php echo BASE_URL; ?>dist_admin/js/custom.js"></script>


<!-- code chỗ này lại 4/8/2025 alert thông báo $_SESSION -->

<?php if (isset($error_message)): ?>
    <script>
        iziToast.error({
            message: '<?php echo $error_message; ?>',
            position: 'topRight',
            timeout: 4000,
            color: 'red',
            icon: 'fa fa-times',
        });
    </script>
<?php endif; ?>


<?php if (isset($success_message)): ?>
    <script>
        iziToast.success({
            message: '<?php echo $success_message; ?>',
            position: 'topRight',
            timeout: 3000,
            color: 'green',
            icon: 'fa fa-check',
        });
    </script>
<?php endif; ?>

<?php if (isset($_SESSION['success_message'])): ?>
    <script>
        iziToast.success({
            message: '<?php echo $_SESSION['success_message']; ?>',
            position: 'topRight',
            timeout: 3000,
            color: 'green',
            icon: 'fa fa-check',
        });
    </script>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>


<?php if (isset($_SESSION['error_message'])): ?>
    <script>
        iziToast.success({
            message: '<?php echo $_SESSION['error_message']; ?>',
            position: 'topRight',
            timeout: 3000,
            color: 'red',
            icon: 'fa fa-times',
        });
    </script>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>


<?php if (isset($_SESSION['toast_message'])): ?>
    <script>
        iziToast.success({
            message: '<?php echo addslashes($_SESSION['toast_message']); ?>',
            position: 'topRight',
            timeout: 3000,
            color: 'yellow',
            icon: 'fa fa-check'
        });
    </script>
    <?php unset($_SESSION['toast_message']); ?>
<?php endif; ?>
</script>

<script>
    document.getElementById('featured_photo').addEventListener('change', function(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let preview = document.getElementById('preview_image');
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
</body>

</html>