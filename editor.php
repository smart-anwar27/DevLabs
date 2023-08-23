<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/account/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart DevLabs - Online HTML, CSS and JS Live Code Editor.</title>

    <!--Layout-->
    <link rel="stylesheet" href="./static/css/design.css">
    <link rel="shortcut icon" href="static/img/Smart.png" type="image/x-icon">
    <link rel="stylesheet" href="./static/icons/css/all.css">

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <?php if (isset($user)): ?>
    
    <nav>
        <label for="nav" class="label"><b>Dev</b>Labs</label>
        <ul>
            <li class="change-layout"><a>Layout</a></li>
            <li class="trigger"><a>Tools</a></li>
        </ul>
        <div class="modal">
            <div class="modal-content">
                <span class="close-button"><small>x</small></span>
                <div class="flex">
                    <div>
                        <h4>Colour Assistant</h4>
                        <br>
                        <br>
                        <span class="color-picker" id="sample">
                            <label for="colorPicker" id="myInput">
                                <input type="color" value="#1DB8CE" id="colorPicker">
                            </label>
                        </span>
                       &nbsp&nbsp
                        <button onclick="CopyToClipboard('sample');return false;"><i class="fa-solid fa-copy"></i></button>
                        <br>
                        <br>
                        <small style="color: grey; font-size: x-small;"><i class="fa-solid fa-info-circle"></i> &nbspChoose your desired colour and click copy button to copy it.</small>
                    </div>
                    <div>
                        <h4>Font Style</h4>
                        <br>
                        <select id="input-font" class="input"  onchange="changeFont (this);">
                            <option value="JetBrains Mono" selected ="selected">JetBrains Mono</option>
                            <option value="Source Code Pro">Source Code Pro</option>
                      </select>
                      <br>
                      <br>
                      <small style="color: grey; font-size: x-small;"><i class="fa-solid fa-info-circle"></i> &nbspChoose your desired font style.</small>
                    </div>
                </div>
                <br>
                <div class="flex">
                    <div>
                        <h4>Font Size</h4>
                        <br>
                        <select id="sizef">
                            <option value="8px">8px</option>
                            <option value="10px">10px</option>
                            <option value="14px">14px</option>
                            <option value="20px">20px</option>
                            <option value="24px">24px</option>
                        </select>
                        <br>
                        <br>
                        <small style="color: grey; font-size: x-small;"><i class="fa-solid fa-info-circle"></i> &nbspChoose your desired font size for the editor.</small>
                        
                    </div>
                    <div>
                        <h4>Export your lab</h4>
                        <br>
                        <button onclick="downloadFile()"><i class="fa-solid fa-download"></i> &nbspHTML</button>
                        <button onclick="downloadFile2()"><i class="fa-solid fa-download"></i> &nbspCSS</button>
                        <button onclick="downloadFile4()"><i class="fa-solid fa-download"></i> &nbspJS</button>
                        <br>
                        <br>
                        <small style="color: grey; font-size: x-small;"><i class="fa-solid fa-info-circle"></i> &nbspExport and save your lab to your local storage.</small>
                    </div>
                </div>
                <br>
                <div class="flex">
                    <div>
                        <h4>Helpful links</h4>
                        <br>
                     <small class="list">
                        <li><a href="/">Learn DevLabs <i class="fa-solid fa-arrow-up-right-from-square fa-xs"></i></a></li>
                        <li><a href="http://youtube.com/devlabs/">Developers on YouTube <i class="fa-solid fa-arrow-up-right-from-square fa-xs"></i></a></li>
                        <li><a href="http://w3schools.com/">Learn Web Development <i class="fa-solid fa-arrow-up-right-from-square fa-xs"></i></a></li>
                        <li><a href="/">DevLabs Pro <i class="fa-solid fa-arrow-up-right-from-square fa-xs"></i></a></li>
                    </small>
                    </div>
                    <div>
                        <p><b>Smart</b>Account</p>
                        <br>
                        <small><?= htmlspecialchars($user["name"]) ?></small>
                        <p><small><?= htmlspecialchars($user["email"]) ?></small></p>
                        <br>
                        <small><a href="account/logout.php"><button style="border: 1px solid dodgerblue; background: none; color: black;">Sign Out</button></a>&nbsp&nbsp&nbsp&nbsp<a href="http://"><button>AccountID</button></a></small>
                    </div>
                </div>
                <br>
                <small align="middle" style="color: gray;">&copy Copyright Smart 2023</p>
            </div>
        </div>
    </nav>

    <div class="container view2">
        <div class="coder view2">
            <div class="code-editor htmlCoder">
                <div class="code-type"><small style="background: orangered;">! ></small>&nbsp HTML</div>
                <div id="tools"><div class="code html" id="html"></div></div>    
            </div>
            <div class="code-editor cssCoder">
                <div class="code-type"><small>{ }</small>&nbsp CSS</div>
                <div id="tools"><div class="code css" id="css"></div></div>  
            </div>
            <div class="code-editor jsCoder">
                <div class="code-type"><small style="background: rgb(225, 196, 2);">( )</small>&nbsp JS</div>
                <div id="tools"><div class="code js" id="javascript"></div></div>
            </div>
        </div>
        <div class="output">
            <iframe src="" class="virtual-iframe" frameborder="0"></iframe>
        </div>
    </div>
    <script src="static/js/copy.js"></script>
    <script src="static/js/color.js"></script>
    <script src="static/js/font.js"></script>
    <script src="static/js/modal.js"></script>
    <script src="static/js/export.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>
    <script src="https://kit.fontawesome.com/bfec29d4e0.js" crossorigin="anonymous"></script>
    <script src="./static/js/app.js"></script>
    <script>
        function CopyToClipboard(id)
{
var r = document.createRange();
r.selectNode(document.getElementById(id));
window.getSelection().removeAllRanges();
window.getSelection().addRange(r);
document.execCommand('copy');
window.getSelection().removeAllRanges();
}
    </script>
      <script>
        const selectFontSize = document.getElementById("sizef");
        const updateElement = document.getElementById("tools");

        selectFontSize.addEventListener("change", function () {
            const selectedValue = selectFontSize.value;
            updateElement.style.fontSize = selectedValue;
        });
    </script>
    <?php else: ?>
        
    <?php header("Location: main.html");
         exit; ?>
     
 <?php endif; ?>
</body>

</html>