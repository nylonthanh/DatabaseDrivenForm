<html>
<head>
    <title>Cleanify Dynamic Form</title>
</head>
<body>
    <table>
        <form action="{$formUrl}" method="post" name="cleanifyForm">
            {foreach $formData as $formField }
                {strip}
                    <tr bgcolor="{cycle values="#eeeeee,#dddddd"}">
                        <td>{$formField.field_value}</td>
                        <td><input type="{$formField.input_type}" name="{$formField.field_name}" id="{$formField.field_name}" value="{$formField.form_value|default: ''}"></td>
                    </tr>
                {/strip}
            {/foreach}
            <tr>
                <td align="right">
                    <input type="reset" value="reset">
                </td>
                <td>
                    <input type="submit" value="submit">
                </td>
            </tr>

        </form>
    </table>
</body>
</html>

