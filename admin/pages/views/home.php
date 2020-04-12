<?php $this->extend('layout') ?>

<?php $this->section('title', 'Strona główna') ?>

<?php $this->startSection('content') ?>
<main id="main">
    <!-- <div class="preface">
        <div class="page-name">mini.pw.edu.pl/~loremipsum</div>
        <div class="page-description">Przegląd strony</div>

        
    </div> -->

    <div class="tile nohover fullwidth" id="search">
        <div class="flex-start"><i class="fas fa-search"></i> Szukaj</div>
        <div class="flex-end"><i class="fas fa-bars"></i><i class="fas fa-envelope"></i><i class="fas fa-bell"></i></div>
    </div>

    <div class="tiles">
        <div class="tiles-title fullwidth">Akcje</div>
        <a class="tile">
            <span class="tile-title"><i class="fas fa-cog"></i>Ustawienia</span>
            <span class="tile-description">Skoro nie wiesz, kim jesteś, przynajmniej miej pewność, kim nie jesteś.</span>
        </a>
        <a id="#myLink" href="#" onclick="openAddPageForm()" class="tile">
            <span class="tile-title"><i class="fas fa-plus"></i>Nowa podstrona</span>
            <span class="tile-description">Nie da się nawet opowiedzieć, dlaczego pewnych rzeczy nie da się opowiedzieć.</span>
        </a>
        <a class="tile">
            <span class="tile-title"><i class="fas fa-plug"></i>Wtyczki</span>
            <span class="tile-description">Prawda i fałsz nie istnieją na zewnątrz naszych głów.</span>
        </a>
        <a class="tile">
            <span class="tile-title"><i class="fas fa-palette"></i>Paleta</span>
            <span class="tile-description">Ci, co upadli na dno, wiedzą, na czym stoją.</span>
        </a>
        <a class="tile">
            <span class="tile-title"><i class="fas fa-adjust"></i>Hmm</span>
            <span class="tile-description">Pieniądze, drogi Sasza, są po to, żeby nie musieć zarabiać pieniędzy.</span>
        </a>
        <a class="tile">
            <span class="tile-title"><i class="fas fa-adjust"></i>Hmm</span>
            <span class="tile-description">Pieniądze, drogi Sasza, są po to, żeby nie musieć zarabiać pieniędzy.</span>
        </a>
    </div>

    <div class="tiles">
        <div class="tiles-title fullwidth">Statystyki</div>
        <div class="tile big nohover">
            <span class="tile-bigtitle">1023</span>
            <span class="tile-description">Odwiedzeń w tym tygodniu</span>
        </div>
        <div class="tile big nohover">
            <span class="tile-bigtitle">991</span>
            <span class="tile-description">Pobranych plików</span>
        </div>
        <div class="tile big nohover alt">
            <span class="tile-bigtitle">12</span>
            <span class="tile-description">Niezdanych kolokwiów</span>
        </div>
    </div>

    <div class="form-popup" id="addPageForm">
        <form action="<?php echo route("adding"); ?>" class="form-container" method="post">
            <?php crsf() ?>
            <h2>Kreator tworzenia nowej podstrony</h2>
            <br>
            <label for="pageName"><b>Nazwa strony</b></label>
            <br>
            <input type="text" placeholder="Podaj nazwę strony" name="name" required>
            <br>
            <label for="pageParent"><b>Strona nadrzędna</b></label>
            <br>
            <input type="text" placeholder="Podaj stronę nadrzędną" name="parent">
            <br>
            <label for="pageTemplate"><b>Szablon</b></label>
            <select name="template">
                <option value="default">Domyślny</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
            <br>
            <button type="submit" class="btn">Utwórz</button>
            <button type="submit" class="btn cancel" onclick="closeAddPageForm()">Anuluj</button>
        </form>
    </div>
</main>
<?php $this->endSection() ?>
