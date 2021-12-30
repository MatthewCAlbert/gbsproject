
                                <form method="post" action="index.php" class="container">
                                    <div class="col">
                                        <h4>Allowed Access</h4>
                                        <input type="checkbox" name="access-1" id="a" />
                                        <label for="a">Retrieve User Data</label><br>
                                        <input type="checkbox" name="access-2" id="b" />
                                        <label for="b">Retrieve Admin Data</label><br>
                                        <input type="checkbox" name="access-3" id="c" />
                                        <label for="c">Top Up</label><br>
                                        <input type="checkbox" name="access-4" id="d" />
                                        <label for="d">Transaction</label>
                                    </div><br>
                                    <div class="col">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" required />
                                    </div><br>
                                    <div class="col">
                                        <label>Type</label>
                                        <select name="type" class="form-control" required>
                                            <option value="1">App</option>
                                            <option value="2">Device</option>
                                            <option value="3">Web</option>
                                        </select>
                                    </div><br>
                                    <div class="col">
                                        <button type="submit" name="submit" class="btn btn-primary">Register</button>
                                    </div>
                                    <br>
                                </form>