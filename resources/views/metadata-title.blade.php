{{-- Uses a regular `echo` expression since blade syntax creates unexpected HTML
entities like `&#039;` that doesnt work correctly when shared for example. --}}
<title><?php echo htmlentities(trim($slot)) ?></title>
