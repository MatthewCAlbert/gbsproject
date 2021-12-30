
                                <form method="post" action="index.php" autocomplete="off">
                                    <div class="col">
                                        <label>Occupation</label>
                                        <select name="target" class="form-control" id="type-filter" onclick="switchFilterOption()" required>
                                            <option value="student">Student</option>
                                            <option value="teacher">Teacher/Staff</option>
                                            <option value="vendor">Vendor</option>
                                        </select>
                                    </div><br>
                                    <script>applyFilterOption();</script>
                                    <div class="col">
                                        <label>ID/NIS</label>
                                        <input type="text" name="id" class="form-control" required>
                                    </div><br>
                                    <div class="col">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div><br>
                                    <div class="col">
                                        <label>Card RFID ID</label>
                                        <input type="text" name="card_id" class="form-control" required>
                                    </div><br>
                                    <div class="col">
                                        <label>Password</label>
                                        <input type="text" name="password" class="form-control" id="password" value="" required>
                                    </div>
                                        <br>
                                    <div class="col">
                                        <button type="submit" name="submit" class="btn btn-primary">Register</button>
                                    </div>
                                    <br>
                                </form>