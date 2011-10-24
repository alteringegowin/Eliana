<div class="block small center login">

    <div class="block_head">
        <div class="bheadl"></div>
        <div class="bheadr"></div>

        <h2>Login</h2>
    </div>		
    <!-- .block_head ends -->


    <div class="block_content">
        <form action="<?php echo current_url() ?>" method="post">
            <p>
                <label>Username:</label> <br />
                <input type="text" name="username" class="text" value="" />
            </p>

            <p>
                <label>Password:</label> <br />
                <input type="password" name="password"  class="text" value="" />
            </p>

            <p>
                <input type="submit" class="submit" value="Login" /> &nbsp;
            </p>
        </form>

    </div>		<!-- .block_content ends -->

    <div class="bendl"></div>
    <div class="bendr"></div>

</div>		<!-- .login ends -->