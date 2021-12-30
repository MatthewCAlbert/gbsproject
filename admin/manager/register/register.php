
                                <form method="post" action="index.php" class="container">
                                    <div class="col">
                                        <label>Access Level</label>
                                        <select name="level" class="form-control" onclick="switchFilterOption()" required>
                                            <option value="1">1 (Help Desk)</option>
                                            <option value="2">2</option>
                                            <option value="3">3 (Booth)</option>
                                            <option value="4">4 (Supervisor)</option>
                                            <option value="5">5 (Master)</option>
                                        </select>
                                    </div><br>
                                    <div class="col">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" required>
                                    </div><br>
                                    <div class="col">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div><br>
                                    <div class="col">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control password" value="" onchange="checkPassword()" required>
                                    </div><br>
                                    <div class="col">
                                        <label>Confirm Password</label>
                                        <input type="password" name="re-password" class="form-control password" value="" onchange="checkPassword()" required>
                                    </div><br>
                                    <div class="col">
                                        <button type="submit" name="submit" class="btn btn-primary">Register</button>
                                    </div>
                                    <br>
                                </form>