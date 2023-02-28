<!-- <li class="nav-item">
  <a class="nav-link active" id="customergroup_tab" data-toggle="pill" href="#customergroup" role="tab"
    aria-controls="customergroup" aria-selected="true">
    Customer Group
  </a>
</li> -->

<li class="nav-item">
  <a class="nav-link" id="customergroup_tab">
    Customer Group
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" id="customer_tab">
    Customer
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" id="hsn_tab">
    HSN
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" id="company_tab" href="/company/view/1">
    Company
  </a>
</li>

<script>
  $(function () {
    $("#company_tab").attr("href", baseUrl + "company/view/1");
    $("#customergroup_tab").attr("href", baseUrl + "customergroups");
    $("#customer_tab").attr("href", baseUrl + "customers");
    $("#hsn_tab").attr("href", baseUrl + "hsn");
  });
</script>