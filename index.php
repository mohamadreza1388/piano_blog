<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پیانو با کیبورد</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
        }
        .key {
            width: 50px;
            height: 200px;
            margin: 5px;
            background-color: white;
            border: 1px solid #000;
            display: inline-block;
            text-align: center;
            line-height: 200px;
            font-size: 18px;
            cursor: pointer;
            user-select: none;
        }
        .key:active {
            background-color: #ccc;
        }
    </style>
</head>
<body>
    <div id="keyboard">
        <?php
        $keys = ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', "[", "]"]; // اضافه کردن دو کلید جدید برای نت‌های F# و G#
        foreach ($keys as $key) {
            echo "<div class='key' data-key='$key'>$key</div>";
        }
        ?>
    </div>
    <script>
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();

        const notes = {
            'q': 261.63, // C4
            'w': 293.66, // D4
            'e': 329.63, // E4
            'r': 349.23, // F4
            't': 392.00, // G4
            'y': 440.00, // A4
            'u': 493.88, // B4
            'i': 523.25, // C5
            'o': 590.33, // D5
            'p': 665.25, // D#5
            "[": 700.25, // E5
            ']': 739.99, // F#5
        };

        function playSound(frequency) {
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();

            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(frequency, audioContext.currentTime);
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);

            oscillator.start();
            oscillator.stop(audioContext.currentTime + 0.2); // Play sound for 0.5 seconds
        }

        document.addEventListener('keydown', function(event) {
            if (notes[event.key]) {
                playSound(notes[event.key]);
                const keyDiv = document.querySelector(`.key[data-key="${event.key}"]`);
                if (keyDiv) {
                    keyDiv.classList.add('active');
                }
            }
        });

        document.addEventListener('keyup', function(event) {
            const keyDiv = document.querySelector(`.key[data-key="${event.key}"]`);
            if (keyDiv) {
                keyDiv.classList.remove('active');
            }
        });

        document.querySelectorAll('.key').forEach(key => {
            key.addEventListener('click', function() {
                const note = notes[this.getAttribute('data-key')];
                if (note) {
                    playSound(note);
                }
            });
        });
    </script>
</body>
</html>
