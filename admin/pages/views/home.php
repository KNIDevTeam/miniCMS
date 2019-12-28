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
            <span class="tile-bigtitle">1023</span>
            <span class="tile-description">Odwiedzeń w tym tygodniu</span>
        </div>
        <a class="tile">
            <span class="tile-title nohover"><i class="fas fa-cog"></i>Ustawienia</span>
            <span class="tile-description">Skoro nie wiesz, kim jesteś, przynajmniej miej pewność, kim nie jesteś.</span>
        </a>
        <a id = "#myLink" href="#" onclick="openAddPageForm()" class="tile">
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
    </div>

    <div class="form-popup" id="addPageForm">
        <form action="<?php echo route("addPage"); ?>" class="form-container">
            <h2>Kreator tworzenia nowej podstrony</h2>
            <br>
            <label for="pageName"><b>Nazwa strony</b></label>
            <br>
            <input type="text" placeholder="Podaj nazwę strony" name="pageName" required>
            <br>
            <label for="pageParent"><b>Strona nadrzędna</b></label>
            <br>
            <input type="text" placeholder="Podaj stronę nadrzędną" name="pageParent">
            <br>
            <label for="pageTemplate"><b>Szablon</b></label>
            <select name="pageTemplate">
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