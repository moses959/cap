<!DOCTYPE html>
<html>
<head>
    <title>圖片標籤生成器</title>
</head>
<body>
    <h1>圖片標籤生成器</h1>
    <form action="/api/caption.php" method="post" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*" required onchange="previewImage(event)">
        <br><br>
        <img id="preview" src="#" alt="預覽圖片" style="max-width:300px; display:none;"/>
        <br><br>
        <button type="submit">生成標籤</button>
    </form>
    <?php if (isset($_GET['caption'])): ?>
        <h3>結果：</h3>
        <p><?= htmlspecialchars($_GET['caption']) ?></p>
    <?php endif; ?>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
