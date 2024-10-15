<div class="foo">
    <div class="col-lg-4">
        <div class="social">
            <ul>
                <li><a href="#"><img src="IMG/fb.png"><span>Facebook</span></a></li>
                <li><a href="#"><img src="IMG/go.png"><span>Google+</span></a></li>
                <li><a href="#"><img src="IMG/tw.png"><span>Twitter</span></a></li>
                <li><a href="#"><img src="IMG/yt.png"><span>Youtube</span></a></li>
            </ul>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="propos">
            <h2 class="foo-headline">À propos</h2>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                <p><br><a href="admin/index.php">Administration</a></p>
            <?php else: ?>
                <p>Vous n'êtes pas administrateur.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="team">        
            <ul>
                <h2 class="foo-headline">Ce site est créé par:</h2>
                <li><a href="#">Fortinat POMBI</a></li>
                <li><a href="#">HAGIL Taymiyya</a></li>
                <li><a href="#">Leon Chepfer</a></li>
                <li><a href="#">Rajit</a></li>
                <li><a href="#">Quentin</a></li>
            </ul>
        </div>  
    </div>
</div>
<div class="rights">
    © 2024 copyright <span class="italic"></span>
</div>

<script type="text/javascript" src="CSS/bootstrap/js/bootstrap.min.js"></script>
