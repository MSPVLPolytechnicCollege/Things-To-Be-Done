<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="container">
            <div class="left">
                <h2>Things To Be Done</h2>
            </div>
            <div class="right">
                <div class="anchor">
                    <a href="#home" class="tab-link active" title="Home" onclick="showTab('home')"><i class="fa-sharp fa-solid fa-house"></i></a>
                    <a href="#View" title="View" class="tab-link" onclick="showTab('view')"><i class="fa-solid fa-eye"></i></a>
                    <a href="#SetRemainder" class="tab-link" title="SetRemainder" onclick="showTab('setremainder')"><i class="fa-solid fa-clock"></i></a>
                    <a href="#Priority" class="tab-link" title="Priority" onclick="showTab('priority')"><i class="fa-solid fa-star"></i></a>
                </div>
                <div id="home" class="tab-content active">
                    <button for="user" onclick="user();"><i class="fa-solid fa-user"></i></button>
                    <br><br><br>
                    <input type="text" placeholder="Add Task.." size="50" id="task">
                    <input type="submit" value="ADD" onclick="add();" id="add">
                </div>
                <div id="view" class="tab-content">
                    hii
                </div>
            </div>
        </div>
        <script>
            function showTab(tabName) {
                // Hide all tab content
                const allTabs = document.querySelectorAll('.tab-content');
                allTabs.forEach(tab => tab.classList.remove('active'));

                // Remove active class from all tab links
                const allLinks = document.querySelectorAll('.tab-link');
                allLinks.forEach(link => link.classList.remove('active'));

                // Show the selected tab content
                document.getElementById(tabName).classList.add('active');
                
                // Set the active class to the clicked link
                const activeLink = document.querySelector(`[href='#${tabName}']`);
                activeLink.classList.add('active');
            }
        </script
    </body>
    
</html>