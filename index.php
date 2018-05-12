<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>YaDisk Restore</title>
    <!--    <script type="text/javascript" src="jquery.js"></script>-->

    <script type="text/javascript"
            src="https://code.jquery.com/jquery-3.1.0.min.js"
            integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="
            crossorigin="anonymous"></script>

    <script type="text/javascript"
            src="https://code.jquery.com/jquery-migrate-3.0.1.min.js"
            integrity="sha256-F0O1TmEa4I8N24nY0bya59eP6svWcshqX1uzwaWC4F4="
            crossorigin="anonymous"></script>

</head>
<body>

<div style="text-align: center; padding-top: 150px; font-size: 20px; ">
    Осталось восстановить <span style="font-size: 40px; font-weight: bold; " id="total_count">(Загрузка счетчика...)</span> файлов из корзины
</div>
<script type="text/javascript">
    $(window).load(function () {
        yadisk_restore.init();
    });

    var yadisk_restore = {
        restore_interval_h: null,
        total_count_interval_h: null,
        init: function () {
            // обновление Общего кол-ва удаленных файлов
            yadisk_restore.restore_interval_h = setInterval(function () {
                yadisk_restore.getTotalCount()
            }, 5000);

            // восстановление
            yadisk_restore.total_count_interval_h = setInterval(function () {
                yadisk_restore.runRestore()
            }, 1000);
        },

        getTotalCount: function () {
            $.ajax({
                url: "api.php",
                data: {type: 'total_count'},
                type: 'POST',
                success: function (data) {

                    $('#total_count').html(data);

                    console.log('Счетчик обновлен. Новое значение ' + data);

                    if (Number(data) === 0) {
                        clearInterval(yadisk_restore.restore_interval_h);
                        clearInterval(yadisk_restore.total_count_interval_h);
                    }
                },
                error: function () {
                    console.log('Ошибка обновления счетчика')
                }
            });
        },

        runRestore: function () {
            $.ajax({
                url: "api.php",
                data: {type: 'restore'},
                type: 'POST'
            });
        }
    };
</script>
</body>
</html>