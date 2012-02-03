<div id="testimonialSubmission">
    <h2>Submit a testimonial</h2>
    
    <br /><br />
    
    <?php if($showFeedback): ?>
        <div class="pc_confirmationMessage">
          Your testimonial has been submitted. <br />
          Thank you very much for helping Plancake grow.
        </div>
    <br /><br /><br />
    <?php else: ?>
    
            <br />


            <form action="<?php echo url_for('submitTestimonial/index') ?>" method="post">
            <table>
                <?php echo $form ?>
                <tr>
                    <td colspan="2">
                    <div id="testimonialAgreement">

                        <h3>Testimonial Agreement</h3>

        <p>
        This Agreement is between you and Danyuki Software Limited,  Company number: 07554549, Registered office: 6 Boundary Road, London, Greater London, N22 6AD (Hereinafter referred to as the Company).
        </p>

        <p>
        You hereby grant to the Company, its successors and assigns, representatives and employees the right to use your testimony, in whole or in part, for any lawful purpose including marketing, promoting and advertising. 
        </p>

        <p>                
        You will not, at any time, be compensated, in any way, and agree to waive any right to any compensation.
        </p>

        <p>
        The Company expressly disclaims responsibility for any consequences or liability attributable to or related to any use, non-use, or interpretation of information contained or not contained in your testimony.
        </p>

        <p>
        You confirm you have the right over the content of your testimony.
        </p>

        <p>
        You confirm the information in your testimony is truthful.
        </p>

        <p>
        You confirm  you are a genuine customer of Plancake.com.
        </p>

        <p>
        You confirm the testimony is your own words - or at least fully approved by you.
        </p>

        <p>
        You confirm the Company has not given you any incentive to submit your testimony.
        </p>

        <p>
        You agree the content of the testimony remains valid at all times. If the testimony becomes not valid, you agree to notify the Company.
        </p>

        <p>
        You authorised the Company to translate and use the translated version of your testimony.
        </p>

        <p>
        You grant the Company permission to crop and resize the picture of your testimony and use the modified version of said picture.
        </p>

        <p>
        Except for any acts of fraud, gross negligence, or willful misconduct, in no event will the Company be liable to you or any third party for any loss of profits, loss of use, loss of revenue, loss of goodwill, any interruption of business, or for any indirect, special, incidental, exemplary, punitive or consequential damages of any kind arising out of or in connection with this Agreement or use or non-use of your testimony regardless of the type of action, whether in contract, tort, strict liability or otherwise, even if the Company has been advised or is otherwise aware of the possibility of such damages.
        </p>

        <p>
        If one party waives its rights to enforce a breach by another party, this failure to enforce its rights will not be held as a waiver of any subsequent breaches.
        </p>

        <p>
        If any provision of this Agreement is declared void or unenforceable by any judicial or administrative authority, this shall not nullify the remaining provisions of this Agreement, provided that the cancellation of such provision does not substantially alter the economic interest of either party in the continued performance of this Agreement.
        </p>

        <p>
        This Agreement is governed and interpreted in accordance with the laws of England and Wales. Any dispute arising in connection with this Agreement and which cannot be settled on an amicable basis shall be submitted to the exclusive jurisdiction of Courts of England and Wales.
        </p>

        <p>
        This Agreement constitutes the entire agreement between the parties relative to the matters referred to herein and supersedes any other agreement, whether oral or writing, which may have existed between You and the Company
        </p>

        <p>
        By clicking the button below to submit your testimonial you acknowledge that you have read all of the terms and conditions set above, understand all of the terms and conditions of this Agreement, and agree to be bound by all of the terms and conditions of this Agreement.
        </p>

                    </div>
                    </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <input type="submit" value="Submit my testimonial" />
                  </td>
                </tr>
              </table>
            </form>
    
    
    <?php endif ?>    
</div>