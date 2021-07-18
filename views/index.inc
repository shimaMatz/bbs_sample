<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>test1</th>
                <th>test2</th>
            </tr>
        </thead>
        <tbody>
        {foreach from=$people item=p key=k}
            <tr>
                <td>{$k}</td>
                <td>{$p}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</body>
</html>
