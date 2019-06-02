<?php
require_once './php/functions.php';
session_start();

$conn = new Connection;
$conn->createDataTable();
$conn->createSchoolTable();
$conn->createLangTable();
$conn->createImageTable();
$conn->createPdfTable();
$validation = new Validation($_POST);
$error = $validation->validation();
$options = new Options;
$month = $options->month;
$level = $options->level;
$errors = FALSE;
$count_words = TRUE;

if (isset($_POST['submit'])) {
    foreach ($_POST['school'] as $a=>$b) {
        if (empty($b)) {
            $errors = TRUE;
        }    
    }
    foreach ($_POST['from'] as $c=>$d) {
        if (empty($d)) {
            $errors = TRUE;
        }    
    }
    foreach ($_POST['to'] as $e=>$f) {
        if (empty($f)) {
            $errors = TRUE;
        }    
    }
    foreach ($_POST['profession'] as $g=>$h) {
        if (empty($h)) {
            $errors = TRUE;
        }    
    }
    foreach ($_POST['lang'] as $i=>$j) {
        if (empty($j)) {
            $errors = TRUE;
        }
    }
    foreach ($_POST['speak'] as $k=>$l) {
        if (empty($l)) {
            $errors = TRUE;
        }    
    }
    foreach ($_POST['read'] as $k=>$l) {
        if (empty($l)) {
            $errors = TRUE;
        }    
    }
    foreach ($_POST['write'] as $k=>$l) {
        if (empty($l)) {
            $errors = TRUE;
        }    
    }
    if (str_word_count($_POST['name']) == 1) {
        $errors = TRUE;
        $count_words = FALSE;
    }
}

if (isset($_POST['submit']) && !$error && $errors == FALSE) {
    $conn->data();
    $conn->school();
    $conn->lang();
    $conn->img();
    if (isset($_FILES['photo'])) {
        move_uploaded_file($_FILES['photo']['tmp_name'], 'images/' . $_FILES['photo']['name']);
    }
}
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CV ģenerēšanas forma</title>
</head>
<body>
    <div>
        <form method="POST" enctype="multipart/form-data" novalidate>
            <label>Vārds, uzvārds
            <?php if (isset($_POST['submit']) && in_array('name', $error) || isset($_POST['submit']) && $count_words == FALSE) : ?>
            <span>Lūdzu ievadiet savu vārdu un uzvārdu</span>
            <?php endif; ?>
            </label><br/>
            <input type="text" name="name" 
            <?php if (isset($_POST['submit']) && $error && $errors == TRUE) { echo 'value="' . htmlentities($_POST['name']) . '"'; } ?>
            /><br/>
            <label>Dzimšanas datums
            <?php if (isset($_POST['submit']) && in_array('day', $error) || isset($_POST['submit']) && in_array('month', $error) || 
            isset($_POST['submit']) && in_array('year', $error)) : ?>
            <span>Lūdzu ievadiet savu dzimšanas datumu</span>
            <?php endif; ?>
            </label><br/>
            <select name="day">
                <option selected></option>
                <?php if (isset($_POST['submit']) && $error && $errors == TRUE) : ?>
                <option <?php echo "selected"; ?>><?php echo htmlentities($_POST['day']); ?></option>
                <?php for ($i = 1; $i <= 31; $i++) : ?>
                <?php if ($_POST['day'] != $i) : ?>
                <option><?php echo $i; ?></option>
                <?php endif; ?>
                <?php endfor; ?>
                <?php else : ?>
                <?php $options->addDay(); ?>
                <?php endif; ?>
            </select>
            <select name="month">
                <option selected></option>
                <?php if (isset($_POST['submit']) && $error && $errors == TRUE) : ?>
                <option <?php echo "selected"; ?>><?php echo htmlentities($_POST['month']); ?></option>
                <?php foreach ($month as $value) : ?>
                <?php if ($_POST['month'] != $value) : ?>
                <option><?php echo $value; ?></option>
                <?php endif; ?>
                <?php endforeach; ?>
                <?php else : ?>
                <?php $options->addMonth(); ?>
                <?php endif; ?>
            </select>
            <select name="year">
                <option selected></option>
                <?php if (isset($_POST['submit']) && $error && $errors == TRUE) : ?>
                <option <?php echo "selected"; ?>><?php echo htmlentities($_POST['year']); ?></option>
                <?php for ($i = 2019; $i >= 1919; $i--) : ?>
                <?php if ($_POST['year'] != $i) : ?>
                <option><?php echo $i; ?></option>
                <?php endif; ?>
                <?php endfor; ?>
                <?php else : ?>
                <?php $options->addYear(); ?>
                <?php endif; ?>
            </select><br/>
            <label>E-pasts 
            <?php if (isset($_POST['submit']) && in_array('email', $error)) : ?>
            <span>Lūdzu ievadiet savu e-pasta adresi</span>
            <?php elseif (isset($_POST['submit']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) : ?>
            <span>Lūdzu ievadiet pareizu e-pasta adresi</span>
            <?php endif; ?>
            </label><br/>
            <input type="email" name="email" 
            <?php if (isset($_POST['submit']) && $error && $errors == TRUE) { echo 'value="' . htmlentities($_POST['email']) . '"'; } ?>            
            /><br/>
            <div class="schools">
                <p>Izglītība
                <?php if (isset($_POST['submit'])) : ?>
                <?php if ($errors == TRUE) : ?>
                <span>Aizpildiet visus laukus par Jūsu izglītību</span>
                <?php endif; ?>
                <?php endif; ?>
                </p>
                <div>
                    <label>Iestādes nosaukums</label><br/>
                    <input type="text" name="school[]" class="school" /><button type="button" class="addSchool">+</button><br/>
                    <label>Gads</label><br/>
                    <label>no</label>
                    <select name="from[]" class="from">
                        <option selected></option>
                        <?php $options->addYear(); ?>
                    </select>
                    <label>līdz</label>
                    <select name="to[]" class="to">
                        <option selected></option>
                        <?php $options->addYear(); ?>
                    </select><br/>
                    <label>Specialitāte</label><br/>
                    <input type="text" name="profession[]" class="profession" />
                </div>
            </div>
            <div class="languages">
                <p>Valodu zināšanas
                <?php if (isset($_POST['submit'])) : ?>
                <?php if ($errors == TRUE) : ?>
                <span>Aizpildiet visus laukus par Jūsu valodas zināšanām</span>
                <?php endif; ?>
                <?php endif; ?>
                </p>
                <div>
                    <input type="text" name="lang[]" class="lang" value="Latviešu" />
                    <label>Runātprasmes</label>
                    <select name="speak[]" class="speak">
                        <option selected></option>
                        <?php $options->addLevel(); ?>                
                    </select>
                    <label>Lasītprasmes</label>
                    <select name="read[]" class="read">
                        <option selected></option>
                        <?php $options->addLevel(); ?>                
                    </select>
                    <label>Rakstītprasmes</label>
                    <select name="write[]" class="write">
                        <option selected></option>
                        <?php $options->addLevel(); ?>                
                    </select>
                </div>
                <div>
                    <input type="text" name="lang[]" class="lang" value="Angļu" />
                    <label>Runātprasmes</label>
                    <select name="speak[]" class="speak">
                        <option selected></option>
                        <?php $options->addLevel(); ?>                
                    </select>
                    <label>Lasītprasmes</label>
                    <select name="read[]" class="read">
                        <option selected></option>
                        <?php $options->addLevel(); ?>                
                    </select>
                    <label>Rakstītprasmes</label>
                    <select name="write[]" class="write">
                        <option selected></option>
                        <?php $options->addLevel(); ?>                
                    </select>
                </div>
                <div>
                    <input type="text" name="lang[]" class="lang" value="Krievu" />
                    <label>Runātprasmes</label>
                    <select name="speak[]" class="speak">
                        <option selected></option>
                        <?php $options->addLevel(); ?>                
                    </select>
                    <label>Lasītprasmes</label>
                    <select name="read[]" class="read">
                        <option selected></option>
                        <?php $options->addLevel(); ?>                
                    </select>
                    <label>Rakstītprasmes</label>
                    <select name="write[]" class="write">
                        <option selected></option>
                        <?php $options->addLevel(); ?>                
                    </select>
                    <button type="button" class="addLang">+</button>
                </div>
            </div>
            <label>Bilde</label><br/>
            <input type="file" name="photo"><br/>
            <input type="submit" name="submit" class="submit_form" value="Iesniegt">
        </form>
        <form method="POST" action="php/pdf.php">
            <input type="submit" name="create" value="Izveidot PDF">
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

            // add another language
            $(document).on('click', '.addLang', function() {
                var html = '<div>';
                    html += '<input type="text" name="lang[]" class="lang" />';
                    html += '<label>Runātprasmes</label>';
                    html += '<select name="speak[] class="speak"><option selected></option>';
                    html += '<?php $options->addLevel(); ?></select>';
                    html += '<label>Lasītprasmes</label>';
                    html += '<select name="read[] class="read"><option selected></option>';
                    html += '<?php $options->addLevel(); ?></select>';
                    html += '<label>Rakstītprasmes</label>';
                    html += '<select name="write[] class="write"><option selected></option>';
                    html += '<?php $options->addLevel(); ?></select>';
                    html += '<button type="button" class="removeLang">-</button>';
                    html += '</div>';
                
                $('.languages').append(html);
            });

            // remove one language
            $(document).on('click', '.removeLang', function() {
                $(this).closest('div').remove();
            });

            // add another school
            $(document).on('click', '.addSchool', function() {
                var html = '<div>';
                    html += '<label>Iestādes nosaukums</label><button type="button" class="removeSchool">-</button><br/>';
                    html += '<input type="text" name="school[]" class="school" /><br/>';
                    html += '<label>Gads</label><br/><label>no</label>';
                    html += '<select name="from[]" class="from"><option selected></option>';
                    html += '<?php $options->addYear(); ?></select>';
                    html += '<label>līdz</label><select name="to[]" class="to"><option selected></option>';
                    html += '<?php $options->addYear(); ?></select><br/>';
                    html += '<label>Specialitāte</label><br/><input type="text" name="profession[]" class="profession" />';
                    html += '</div>';

                    $('.schools').append(html);
            });

            // remove one school
            $(document).on('click', '.removeSchool', function() {
                $(this).closest('div').remove();
            });
        });
    </script>
</body>
</html>
