  <!--==================================
=============== Js File ===========
===================================-->
<script src="{{asset("libs/jquery/dist/jquery.min.js")}}"></script>
<script src="{{asset("libs/bootstrap/dist/js/bootstrap.bundle.min.js")}}"></script>
<script src="{{asset("libs/list.js/dist/list.min.js")}}"></script>
<script src="{{asset("libs/sweetalert/dist/sweetalert2.min.js")}}"></script>
<script src="{{asset("landing-assets/js/bootstrap-select.min.js")}}"></script>
<script src="{{asset("js/floating-wpp.min.js")}}"></script>

<!-- JS -->
<script src="{{asset("js/theme.min.js")}}"></script>
<script>
  let services = {"airtime":["mtn","glo","airtel","9mobile"],"data":["mtn-data","glo-data","airtel-data","9mobile-data"],"cable":["dstv","gotv","startimes"],"power":["aedc-electric","eko-electric","ikeja-electric","jos-electric","kano-electric","portharcourt-electric","ibadan-electric"]};

  function onServiceCategorySelected() {
    let serviceForm = document.getElementById('service-form')
    let serviceCategoriesField = document.getElementById('service-categories-field')
    let servicesField = document.getElementById('services-field')
    let categoryServices = services[serviceCategoriesField.value]
    servicesField.innerHTML = ""

    categoryServices.forEach((service, index) => {
      let element = document.createElement('option')
      element.setAttribute('value', service)
      element.innerText = getServiceTitle(service)
      servicesField.appendChild(element)
      $('#services-field').selectpicker('refresh')
    })
    serviceForm.setAttribute('action', getServiceUrl(serviceCategoriesField.value, categoryServices[0]))
  }

  function onServiceSelected() {
    let serviceForm = document.getElementById('service-form')
    let serviceCategoriesField = document.getElementById('service-categories-field')
    let servicesField = document.getElementById('services-field')

    serviceForm.setAttribute('action', getServiceUrl(serviceCategoriesField.value, servicesField.value))
  }

  function getServiceUrl(category, service) {
    switch (category) {
      case 'airtime':
      return `/airtime-topup/${service}`
      case 'data':
      return `/data-topup/${service.replace('-data', '')}`
      case 'power':
      return `/power-subscription/${service}`
      case 'cable':
      return `/cable-subscription/${service}`
    }
  }

  function getCategoryUrl(category) {
    switch (category) {
      case 'airtime':
      return `/airtime-topup`
      case 'data':
      return `/data-topup`
      case 'power':
      return `/power-subscription`
      case 'cable':
      return `/cable-subscription`
    }
  }

  function getServiceTitle(service) {
    let capitalize = (s) => {
      if (typeof s !== 'string') return ''
        return s.charAt(0).toUpperCase() + s.slice(1)
    }

    switch (service) {
      case 'mtn':
      return 'MTN Airtime Purchase';
      case 'glo':
      return 'GLO Airtime Purchase';
      case 'airtel':
      return 'AIRTEL Airtime Purchase';
      case '9mobile':
      return '9MOBILE Airtime Purchase';
      case 'mtn-data':
      return 'MTN Data Purchase';
      case 'glo-data':
      return 'GLO Data Purchase';
      case 'airtel-data':
      return 'AIRTEL Data Purchase';
      case '9mobile-data':
      return '9MOBILE Data Purchase';
      case 'dstv':
      return 'DSTV Subscription';
      case 'gotv':
      return 'GOTV Subscription';
      case 'startimes':
      return 'STARTIMES Subscription';
      case 'aedc-electric':
      return 'Abuja Electricity Distribution Company (AEDC) Subscription';
      case 'eko-electric':
      return 'Eko Electricity Distribution Company (EKEDC) Subscription';
      case 'ikeja-electric':
      return 'Ikeja Electricity Distribution Company (IKEDC) Subscription';
      case 'jos-electric':
      return 'Jos Electricity Distribution Company (JEDC) Subscription';
      case 'kano-electric':
      return 'Kano Electricity Distribution Company (KEDC) Subscription';
      case 'portharcourt-electric':
      return 'Port Harcourt Electricity Distribution Company (PHED) Subscription';
      case 'ibadan-electric':
      return 'Ibadan Electricity Distribution Company (IBEDC) Subscription';
    }

    return '';
  }
</script>

<script>
  function postDummy(url) {
    var form = $('form#dummy-form')
    form.attr('action', url)
    form.submit()
  }
</script>

<script type="text/javascript">
  $(function () {
    $('#save-beneficiary-toggle').hide()
    $('#beneficiary-name-container').hide()
    $('#phone-field').keyup(function () {
      if ($(this).val().length > 0) {
        $('#save-beneficiary-toggle').show()
      } else {
        $('#save-beneficiary-toggle').hide()
        $('#beneficiary-name-container').hide()
      }
    })
    $("#save-beneficiary-toggle").click(function () {
      $('#beneficiary-name-container').toggle('fast', function () {
        if ($(this).is(':hidden')) {
          $('#beneficiary-name-field').val('')
        }
      })
    });
  });

  function setBeneficiary(billersCode) {
    $('#phone-field').val(billersCode)
  }
</script>
<script>
  function updateAmount(amount) {
    let selectEl = document.getElementById("variation-select")
    let selectedAmount = selectEl.options[selectEl.selectedIndex].dataset.amount
    document.getElementById('amount-field').value = selectedAmount
  }
</script>
<script>
  function deleteBeneficiary(url) {
    swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!'
    }).then(function (result) {
      if (result.value) {
        this.postDummy(url)
      }
    });
  }
</script>

<!--Start of WhatsApp Chat Script-->
<script type="text/javascript">

  $(function () {
    $('.floating-wpp').floatingWhatsApp({
      phone: '2348166861397',
      popupMessage: 'Welcome to NaijaWayServices, if you need help simply reply to this message, we are online and ready to help.',
      showPopup: true,
      position: 'right',
      autoOpen: false,
            //autoOpenTimer: 4000,
            message: '',
            //headerColor: 'orange',
            headerTitle: 'WhatsApp Message',
          });
  });

</script>