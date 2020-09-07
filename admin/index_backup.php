          <?php 
                if(!empty($_GET['pageno'])) {
                  $pageno = $_GET['pageno'];
                } else {
                  $pageno = 1;
                }
                $numOfrecs = 4;
                $offset = ($pageno -1 ) * $numOfrecs;

                if(empty($_POST['search']) && empty($_COOKIE['search'])) {
                    $stm = $pdo->prepare("
                    SELECT * FROM posts ORDER BY id DESC
                    ");

                    if($stm->execute()) {
                      $rawResult = $stm->fetchAll();
                    }

                    $total_pages = ceil(count($rawResult)/ $numOfrecs);

                    $stm = $pdo->prepare("
                      SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs
                    ");

                    if($stm->execute()) {
                      $result = $stm->fetchAll();
                    }
                } else {
                    $searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
                    $stm = $pdo->prepare("
                    SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC
                    ");

                    if($stm->execute()) {
                      $rawResult = $stm->fetchAll();
                    }

                    $total_pages = ceil(count($rawResult)/ $numOfrecs);

                    $stm = $pdo->prepare("
                    SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs
                    ");

                    if($stm->execute()) {
                      $result = $stm->fetchAll();
                    }
                }
                
              ?>


                  <?php if($result): ?>
                      <?php $i= 1;?>  
                        <?php foreach($result as $results): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo escape($results['title'])?></td>
                                <td>
                                  <?php echo escape(substr($results['content'], 0, 58))?>
                                </td>
                                <td>
                                  <a href="edit.php?id=<?php echo $results['id'];?>" type="button" class="btn btn-warning">Edit</a>
                                  <a href="delete.php?id=<?php echo $results['id'];?>" 
                                  onclick="return confirm('Are you sure you want to delete this item')"
                                  type="button" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>                 
                    <?php endif; ?>  


                  <div class="float-right">
                  <nav aria-label= "Page navigation example" class="mt-4">
                      <ul class="pagination">
                          <li class="page-item"> <a href="?pageno=1" class="page-link">First</a></li>
                          <li class="page-item <?php if($pageno <= 1){echo 'disabled';} ?>"> 
                            <a href="<?php if($pageno <= 1){echo '#';} else {echo '?pageno='.($pageno-1);}?>" class="page-link">Previous</a>
                          </li>
                          <li class="page-item"> <a href="#" class="page-link"><?php echo $pageno; ?></a></li>
                          <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';} ?>"> 
                            <a href="<?php if($pageno >=$total_pages){echo '#';} else {echo '?pageno='.($pageno+1);}?>" class="page-link">Next</a>
                          </li>
                          <li class="page-item"> <a href="?pageno=<?php echo $total_pages; ?>" class="page-link">Last</a></li>
                      </ul>
                  </nav>
                </div>