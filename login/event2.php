<?php
session_start();
include('dbh.php');
include('functions.php');
include('inc/header.php');

?>
  <div class="header-bg"></div>
<div class="container" style="padding-bottom:60px;">
    <div class="row">
      <div class="twelve columns">
        <div class="section-header">
        <h4>
          Tapahtuma
           </h4>
         </div>
      </div>
    </div>
    <div class="twelve columns" style="text-align:center;margin-top:35px;margin-bottom:20px;">
    <div class="section1">
    <p class="guide-header">Tapahtuman tiedot</p>
    <a href="event1.php" style="text-decoration:none">
    <i class="material-icons guide">filter_1</i>
    </a></div>
    <div class="line" style="background-color:#2bc9c9"></div>

    <div class="section2" style="background-color:#2bc9c9">
    <p class="guide-header">Kotipelaajat</p>
    <a href="#" style="text-decoration:none">
    <i class="material-icons guide">filter_2</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div class="section3" style="background-color:gray">
    <p class="guide-header">Vieraspelaajat</p>
    <a id="btnEvent3" href="#" style="text-decoration:none">
    <i class="material-icons guide">filter_3</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div class="section4" style="background-color:gray">
    <p class="guide-header">Ennakkoteksti</p>
    <a id="btnEvent4" href="#" style="text-decoration:none">
    <i class="material-icons guide">filter_4</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div class="section5" style="background-color:gray">
    <p class="guide-header">Mainospaikat</p>
    <a id="btnEvent5" href="#" style="text-decoration:none">
    <i class="material-icons guide">filter_5</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div class="section6" style="background-color:gray">
    <p class="guide-header">    Kilpailu</p>
    <a id="btnEvent6" href="#" style="text-decoration:none">
    <i class="material-icons guide">filter_6</i>
    </a></div>
    <div class="line" style="background-color:gray"></div>

    <div class="section7" style="background-color:gray">
    <p class="guide-header">Yhteenveto</p>
    <a id="btnEvent7" href="#" style="text-decoration:none">
    <i class="material-icons guide">filter_7</i>
    </a></div>
    </div>

  <div class="row">
    <div class="twelve columns">
      <span class="msg msg-fail" id="msg"></span>
    </div>
  </div>

      <div class="shadow-box2">
        <div class="twelve columns">
        <label style="margin-left:4%;">Esitystapa</label>
        <select id="display" style="margin-left:4%;" onchange="select()">
          <option selected value="1">Lista</option>
          <option value="2">Kentälliset</option>
        </select>
      </div>

        <div class="field six columns">
          <div class="first-line shadow-box-position">
          <h5 style="color:#6f6f67">
            1. Kenttä
          </h5>
            <div class="position">
              <div class="box">
              </div>
              <div class="position-info 1-1"><p>Hyökkääjä</p></div>
          </div>
          <div class="position">
            <div class="box">
            </div>
            <div class="position-info 1-2"><p>Hyökkääjä</p></div>
        </div>
        <div class="position">
          <div class="box">
          </div>
          <div class="position-info 1-3"><p>Hyökkääjä</p></div>
      </div>
      <div class="position">
        <div class="box">
        </div>
        <div class="position-info 1-4"><p>Puolustaja</p></div>
    </div>
    <div class="position">
      <div class="box">
      </div>
      <div class="position-info 1-5"><p>Puolustaja</p></div>
  </div>
        </div>
<div class="second-line shadow-box-position">
        <h5 style="color:#6f6f67">
          2. Kenttä
        </h5>
          <div class="position">
            <div class="box">
            </div>
            <div class="position-info 2-1"><p>Hyökkääjä</p></div>
        </div>
        <div class="position">
          <div class="box">
          </div>
          <div class="position-info 2-2"><p>Hyökkääjä</p></div>
      </div>
      <div class="position">
        <div class="box">
        </div>
        <div class="position-info 2-3"><p>Hyökkääjä</p></div>
    </div>
    <div class="position">
      <div class="box">
      </div>
      <div class="position-info 2-4"><p>Puolustaja</p></div>
  </div>
  <div class="position">
    <div class="box">
    </div>
    <div class="position-info 2-5"><p>Puolustaja</p></div>
</div>
      </div>
      <div class="third-line shadow-box-position">
              <h5 style="color:#6f6f67">
                3. Kenttä
              </h5>
                <div class="position">
                  <div class="box">
                  </div>
                  <div class="position-info 3-1"><p>Hyökkääjä</p></div>
              </div>
              <div class="position">
                <div class="box">
                </div>
                <div class="position-info 3-2"><p>Hyökkääjä</p></div>
            </div>
            <div class="position">
              <div class="box">
              </div>
              <div class="position-info 3-3"><p>Hyökkääjä</p></div>
          </div>
          <div class="position">
            <div class="box">
            </div>
            <div class="position-info 3-4"><p>Puolustaja</p></div>
        </div>
        <div class="position">
          <div class="box">
          </div>
          <div class="position-info 3-5"><p>Puolustaja</p></div>
      </div>
            </div>
            <div class="fourth-line shadow-box-position">
                    <h5 style="color:#6f6f67">
                      4. Kenttä
                    </h5>
                      <div class="position">
                        <div class="box">
                        </div>
                        <div class="position-info 4-1"><p>Hyökkääjä</p></div>
                    </div>
                    <div class="position">
                      <div class="box">
                      </div>
                      <div class="position-info 4-2"><p>Hyökkääjä</p></div>
                  </div>
                  <div class="position">
                    <div class="box">
                    </div>
                    <div class="position-info 4-3"><p>Hyökkääjä</p></div>
                </div>
                <div class="position">
                  <div class="box">
                  </div>
                  <div class="position-info 4-4"><p>Puolustaja</p></div>
              </div>
              <div class="position">
                <div class="box">
                </div>
                <div class="position-info 4-5"><p>Puolustaja</p></div>
            </div>
                  </div>
                  <div class="fifth-line shadow-box-position">
                          <h5 style="color:#6f6f67">
                            5. Kenttä
                          </h5>
                            <div class="position">
                              <div class="box">
                              </div>
                              <div class="position-info 5-1"><p>Hyökkääjä</p></div>
                          </div>
                          <div class="position">
                            <div class="box">
                            </div>
                            <div class="position-info 5-2"><p>Hyökkääjä</p></div>
                        </div>
                        <div class="position">
                          <div class="box">
                          </div>
                          <div class="position-info 5-3"><p>Hyökkääjä</p></div>
                      </div>
                      <div class="position">
                        <div class="box">
                        </div>
                        <div class="position-info 5-4"><p>Puolustaja</p></div>
                    </div>
                    <div class="position">
                      <div class="box">
                      </div>
                      <div class="position-info 5-5"><p>Puolustaja</p></div>
                  </div>
                        </div>
                        <div class="goalie-line shadow-box-position">
                                <h5 style="color:#6f6f67">
                                  Maalivahdit
                                </h5>
                                  <div class="position">
                                    <div class="box">
                                    </div>
                                    <div class="position-info 6-1"><p>Maalivahti</p></div>
                                </div>
                                <div class="position">
                                  <div class="box">
                                  </div>
                                  <div class="position-info 6-2"><p>Maalivahti</p></div>
                              </div>
                              <div class="position">
                                <div class="box">
                                </div>
                                <div class="position-info 6-3"><p>Maalivahti</p></div>
                            </div>
                              </div>
        </div>
      <div class="six columns out" style="width:44%;">
        <h5 style="color:#6f6f67">
          Poistetut pelaajat
        </h5>
         <table class="u-full-width">
           <tbody class="removed">

         </tbody>
          </table>
      </div>

      <div class="six columns in" style="width:44%;">
        <h5 style="color:#6f6f67">
          Tapahtuman pelaajat
        </h5>
          <table class="u-full-width">
            <tbody class="added">
          <?php
          listHomeTeam();
          ?>
        </tbody>
        </table>
      </div>
    </div>
      </div>
      <div class="twelve columns event-buttons">
     <input type="button" value="Takaisin" onclick="window.location='event1.php'"/>
      <input class="button-primary" type="submit" id="btnEvent3" value="Seuraava">
      </div>
    <script src="js/drag.js"></script>
    <script>

    $('#btnEvent3, #btnEvent4, #btnEvent5, #btnEvent6, #btnEvent7').click(function(event){
        var selected = ($(this).attr("id"));
        event.preventDefault();
        var numbers = $('.numbers.enabled').serializeArray();
        var firstnames = $('.firstnames.enabled').serializeArray();
        var lastnames = $('.lastnames.enabled').serializeArray();
        var roles = $('.roles.enabled').serializeArray();
        var positions = $('.positions.enabled').serializeArray();
        var finish = $.post("functions.php", { setHomeTeam: 'hometeam', homeNumbers: numbers, homeFirstNames: firstnames, homeLastNames: lastnames, homeRoles: roles, homePositions: positions }, function(data) {
          if(data){
            console.log(data);
          }
          message(data,selected);

        });
    });
    </script>

  <?php include('inc/footer.php'); ?>
