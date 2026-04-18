

<h2>.................Test Page reached!</h2>
<dev>
<form name ="test" action ="<?php echo URLROOT; ?>/officer/test/calculate" method="POST">

                    <label for="Select oprtation">Select Operation</label>

                      <select id="operation" name="operation">
                            
                            <option value="+">addition</option>
                            <option value="-">Substraction</option>
                            <option value="*">Multiplication</option>
                            <option value="/">Devision</option>
                      </select>

    <input type="text" name="num1" placeholder="Number 1">
    <input type="text" name="num2" placeholder="Number 2">
    <input type="submit" name="calbtn" value="Calculate">
    <input type="text" name="result" placeholder="result" value = "<?php echo isset($data['finResult'] )? $data['finResult'] : ' ' ;?>" >
    <?php echo isset($data['error'])? $data['error'] : '' ;?>
</form>

</dev>

<br><br><br>

<dev>
    <form name ="farmernote" action ="<?php echo URLROOT; ?>/officer/test/create" method="POST">
    <input type="text" name="farmer_ID" placeholder= "Farmer ID"><br><br>
    <textarea name = "note" rows ="4" cols = "50" placeholder = "Enter Note Here..."></textarea><br>
                      
    <select id="note_piority" name="note_piority">
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
    </select>

    <input type="submit" name="subbtn" value="Submit">
    </form>

    <form action ="<?php echo URLROOT; ?>/officer/test" method="GET">

    <label>Filter</lable>                      
    <select 
        name="filter" 
        onchange="this.form.submit()"
    >
        <option value="high" <?php if($data['filter']=='high') echo 'selected'; ?>>High</option>
        <option value="medium" <?php if($data['filter']=='medium') echo 'selected'; ?>>Medium</option>
        <option value="low" <?php if($data['filter']=='low') echo 'selected'; ?>>Low</option>
        <option value="" <?php if($data['filter']=='') echo 'selected'; ?>>All</option>
    
    
    </select>

    </form>

       <table class="request-table">
        <thead>
            <tr>
                <th>id</th>
                <th>Farmer ID</th>
                <th>Note</th>
                <th>Priority</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($data['list'])): ?>
                <?php foreach ($data['list'] as $list): ?>
                    <tr>
                        <td><?php echo $list->id; ?></td>
                        <td><?php echo $list->farmer_id; ?></td>
                        <td><?php echo $list->note; ?></td>
                        <td><?php echo $list->priority; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No note Found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <form name ="farmernote" action ="<?php echo URLROOT; ?>/officer/test/search" method="POST">
    <input type="text" name="farmer_ID" placeholder= "Farmer ID"><br><br>
    <input type="submit" name="search" value="Search">
    </form>

            <table>
            <thead>
                <tr>
                    <th>Farmer ID</th>
                    <th>Note</th>
                <tr>
            <thead>

           <tbody>
                    <?php if (!empty($data['result'])):?>
                        <?php foreach($data['result'] as $item): ?>

                            <tr>
                                <td><?php echo $item->farmer_id; ?></td>
                                <td><?php echo $item->note; ?></td>
                                <td><?php echo $item->priority; ?></td>
                                <td>
                                    <a href="<?php echo URLROOT; ?>/officer/test/edit/<?php echo $item->id; ?>" class="btn view">
                                        edit
                                    </a>
                                </td>
                                <td>
                                    <a href="<?php echo URLROOT; ?>/officer/test/delete/<?php echo $item->id; ?>" class="btn view">
                                        Delete
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td >No Notes</td>
                        </tr>
                    <?php endif; ?>

                    <?php if (!empty($data['request'])): ?>
                        <form name ="editform" action ="<?php echo URLROOT; ?>/officer/test/save" method="POST" >
                                <input type="hidden" name="id"  value = "<?php echo $data['request']->id?>">
                                <input type="text" name="farmer_ID" placeholder= "Farmer ID" value = "<?php echo $data['request']->farmer_id?>"><br><br>
                                <textarea name = "note" rows ="4" cols = "50" placeholder = "Enter Note Here..."><?php echo $data['request']->note?></textarea><br>

                                    <select id="note_piority" name="note_piority">
                                                <option value="high" <?= ($data['request']->priority=='high')?'selected':'' ?>>High</option>
                                                <option value="medium" <?= ($data['request']->priority=='medium')?'selected':'' ?>>Medium</option>
                                                <option value="low" <?= ($data['request']->priority=='low')?'selected':'' ?>>Low</option>
                                    </select>

                                <input type="submit" name="update" value="save">
                        </form>
                    <?php endif; ?>
           </tbody>

</dev>


<?php require_once APPROOT . '/views/inc/footer.php'; ?>