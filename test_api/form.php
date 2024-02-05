<div class="panel">
        <div class="overlay hidden">
            <div class="overlay-content"><img src="css/loading.gif" alt="Processing..." /></div>
        </div>

        <div class="panel-heading">
            <h3 class="panel-title">AFRIKPAY</h3> 
            <p><b> Orange money cm</p>
            <form action="index.php" >
                <select class="form-control" name="omoney">
                    <option value="mpayment">account Deposite</option>
                    <option value="cashout">wthdrawal</option>
                </select>
                 <input type="text" class="form-control" placeholder='Full name' name="name" required>
                 <input type="number" class="form-control" placeholder='Phone number' name="phone" required>
                 <input type="email" class="form-control" placeholder='Email address' name="email" required>
                 <input type="number" class="form-control" placeholder='Deposit Amount' name="amount" required>
                 <input type="text" class="form-control" placeholder='Reference Number' name="referenceNumber" required>
                 <input type="text" class="form-control" placeholder='Callback url' name="callback" required>
                 <input type="text" class="form-control" placeholder='Request Id' name="RequestId" required>
                 <input type="text" class="form-control" placeholder='Option Slug' name="optionSlug" required>
                 <input type="number" class="form-control" placeholder='External Id' name="Externald" required>
                 <input type="text" class="form-control" placeholder='Descripton' name="description" required>
                <button type="submt">Send</button>
            </form>
        </div>
    </div>


