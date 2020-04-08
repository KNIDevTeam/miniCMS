<?php $this->extend('layout') ?>

<?php $this->section('title', 'Strona główna') ?>

<?php $this->startSection('content') ?>
<main id="main">
    <div class="preface">
        <div class="page-name">mini.pw.edu.pl/~loremipsum</div>
        <div class="page-description">Przegląd strony</div>
    </div>

    <div class="tile fullwidth nohover">
        Jednak to, co nas wyróżnia - mnie i Pana i innych nam podobnych - to pewne szczególne wyczulenie na Prawdę, i to na ten najwyższy jej rodzaj,
        niepochodzący z badań wnętrza duchowego ani z badań życia społecznego - nie jesteśmy poetami, sędziami, politykami, lekarzami - lecz z najgłębszego
        porządku rzeczywistości - jesteśmy matematykami, fizykami, chemikami, odkrywcami zagadek bytu i wynalazcami metod wykorzystywania cudownej
        natury świata. Czyż można się odwrócić od takiej Prawdy? Któż z widzących z własnej woli wyłupie sobie oczy, jako że przyszło mu żyć między
        miljonem ślepców?
    </div>

    <div class="tiles">
        <div class="tile nohover">
            <span class="tile-bigtitle gradient">1023</span>
            <span class="tile-description">Odwiedzeń w tym tygodniu</span>
        </div>
        <div class="tile">
            <a href="#" class="tile-title nohover"><i class="fas fa-cog"></i>Ustawienia</a>
            <span class="tile-description">Skoro nie wiesz, kim jesteś, przynajmniej miej pewność, kim nie jesteś.</span>
        </div>
        <div class="tile">
            <a id = "#myLink" href="#" onclick="openAddPageForm()" class="tile-title"><i class="fas fa-plus"></i>Nowa podstrona</a>
            <span class="tile-description">Nie da się nawet opowiedzieć, dlaczego pewnych rzeczy nie da się opowiedzieć.</span>
        </div>
        <div class="tile">
            <a href="#" class="tile-title"><i class="fas fa-plug"></i>Wtyczki</a>
            <span class="tile-description">Prawda i fałsz nie istnieją na zewnątrz naszych głów.</span>
        </div>
        <div class="tile">
            <a href="#" class="tile-title"><i class="fas fa-palette"></i>Paleta</a>
            <span class="tile-description">Ci, co upadli na dno, wiedzą, na czym stoją.</span>
        </div>
        <div class="tile">
            <a href="#" class="tile-title"><i class="fas fa-adjust"></i>Hmm</a>
            <span class="tile-description">Pieniądze, drogi Sasza, są po to, żeby nie musieć zarabiać pieniędzy.</span>
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
