 <footer>
        Copyright <?php echo date("Y") ?>, Widget Corp
    </footer>

</body>

</html>

<?php
    if(isset($db_connection)) {
        mysqli_close($db_connection);
    }
?>