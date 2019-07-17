
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Statistika</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if(empty($title)){echo "class='active'";}?>><a href="index.php">Table Frekuensi</a></li>
        <li <?php if($title=='nb'){echo "class='active'";}?>><a href="naive-bayes.php">Naive Bayes</a></li>
        <li <?php if($title=='nbc'){echo "class='active'";}?>><a href="naive-bayes-clasification.php">Naive Bayes Clasification</a></li>
        <li <?php if($title=='kmeans'){echo "class='active'";}?>><a href="kmeans.php">K-(Mean, Modus, Median)</a></li>
        <li <?php if($title=='knn'){echo "class='active'";}?>><a href="knn.php">K-nearest Neighbor</a></li>
        <li <?php if($title=='ttd'){echo "class='active'";}?>><a href="ttd.php">Tanda Tangan</a></li>
    </div>
  </div>
</nav>