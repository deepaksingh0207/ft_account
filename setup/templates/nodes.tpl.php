<div id="wait"><br>Testing connection... please wait</div>
  <div id="inner">
    <div class="middle"></div>
    <main>
    <form action= method="post" id="node_conf"  novalidate="novalidate">
      <h2>Add Nodes</h2>
      <table id="nodeFormTable" class="data forms" border="0">
        <tr id="formHeader">
          <td width="10%">System</td>
          <td width="10%">Description</td>
          <td width="10%">Server IP</td>
          <td width="10%">Instance No.</td>
          <td width="10%">System ID</td>
          <td width="10%">Client</td>
          <td width="10%">user</td>
          <td width="10%">Password</td>
        </tr>
        
        <tr>
          <td><select name="type[]" id="type0" required>
              <option value="">Select</option>
              <option value="source" selected>Source</option>
              <option value="target">Target</option>
			</select>
		 </td>
		 <td><input type="text" name="description[]" id="desc0" required maxlength="40" /></td>
		 <td><input type="text" name="server_ip[]" id="server0" required pattern="(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)" oninvalid="this.setCustomValidity('Enter valid server IP')" oninput="this.setCustomValidity('')" />
		 <span class="err" id="server0_error">IP already added in list.</span></td>
		 <td><input type="text" name="instance_no[]" id="instance0" required maxlength="2" pattern="\d{2}" oninvalid="this.setCustomValidity('Enter 2 digit numeric Instance no.')" oninput="this.setCustomValidity('')"/></td>
		 <td><input type="text" name="system_id[]" id="system_id0" required   maxlength="3"/></td>
		 <td><input type=text name="client[]" id="client0" required maxlength="3" pattern="\d{3}" oninvalid="this.setCustomValidity('Enter 3 digit numeric client')" oninput="this.setCustomValidity('')" /></td>
		 <td><input type="text" name="username[]" id="user0" required/></td>
		 <td><input type="password" name="password[]" id="password0" required /></td>
        </tr>
        
        <tr>
          <td><select name="type[]" id="type1" required>
              <option value="">Select</option>
              <option value="source" >Source</option>
              <option value="target" selected>Target</option>
			</select>
		 </td>
		 <td><input type="text" name="description[]" id="desc1" required  maxlength="40"/></td>
		 <td><input type="text" name="server_ip[]" id="server1" required pattern="(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)" oninvalid="this.setCustomValidity('Enter valid server IP')" oninput="this.setCustomValidity('')" />
		 <span class="err" id="server1_error">IP already added in list.</span></td>
		 <td><input type="text" name="instance_no[]" id="instance1"required maxlength="2" pattern="\d{2}" oninvalid="this.setCustomValidity('Enter 2 digit numeric Instance no.')" oninput="this.setCustomValidity('')" /></td>
		 <td><input type="text" name="system_id[]" id="system_id1" required maxlength="3" /></td>
		 <td><input type="text" name="client[]" id="client1" required maxlength="3" pattern="\d{3}" oninvalid="this.setCustomValidity('Enter 3 digit numeric client')" oninput="this.setCustomValidity('')"  /></td>
		 <td><input type="text" name="username[]" id="user1" required /></td>
		 <td><input type="password" name="password[]" id="password1" required  /></td>
        </tr>
      </table>
      
      <br />
      
      
      <footer class="clearfix">
    <div id="buttons">
    	<button type="button" class="button" id="removeNode" >Remove Node</button>
    	<button type="button" class="button" id="addNode" >Add Node</button>
      <button type="submit" class="button" name="nodeForm">Generate License</button>
    </div>
  </footer>
</form>
    </main>
  </div>