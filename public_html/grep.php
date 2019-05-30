<?php
    $command = "grep -ri 'Mystring' ./*/*/*";
    $output = shell_exec($command);
    echo "$output";
    echo "Grep job over.";
?>