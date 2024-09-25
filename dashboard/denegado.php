<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Denegado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        
        .container {
            width: 80%;
            max-width: 600px;
            margin: 100px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            text-align: center;
            color: #FF5733;
        }
        
        p {
            margin-bottom: 20px;
        }
        
        .department {
            font-weight: bold;
        }
        
        .message {
            text-align: center;
            font-size: 18px;
            color: #555;
        }
        
        .button-container {
            text-align: center;
        }
        
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #FF5733;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        
        .button:hover {
            background-color: #e64c00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Acceso Denegado</h1>
        <p class="message">Lo sentimos, la dirección IP desde la que estás accediendo no tiene permiso para ver esta página.</p>
        <p class="message">Por favor, contacta al departamento de TI para obtener más información.</p>
        <div class="button-container">
            <a href="#" class="button">Contactar a TI</a>
        </div>
    </div>
</body>
</html>
