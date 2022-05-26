<tr class="child">
    <td colspan="11">
        <table class="table table-hover table-borderless table-info">
            <thead>
                <tr>
                    <th colspan="15" style="text-align: center;">Employee Appraisal Behaviours</th>
                </tr>
                <tr>

                    <td><b>Behaviour Name</b></td>
                    <td><b>Weight</b></td>


                    <td class="text text-bold text-center">M.Yr Employee Rating</td>
                    <td class="text text-bold text-center ">M.Yr Employee Comments</td>
                    <td><b>M.Yr Supervisor Rating</b></td>
                    <td><b>M.Yr Supervisor Comments</b></td>
                    <td class="text text-bold text-center text-info"><b>M.Yr Agreement</b></td>
                    <td class="text text-bold text-center text-info"><b>Mid Year Disagreement Comments</b></td>


                    <td class="text text-bold "><b>Self Rating</b></td>
                    <td class="text text-bold text-center "><b>Appraisee Remark</b></td>





                    <td><b>Overall Remarks</b></td>
                    <td class="text text-bold text-center "><b>Agree</b></td>
                    <td class="text text-bold text-center "><b>Disagrement Reason</b></td>

                </tr>
            </thead>
            <tbody>
                <?php if (is_array($model->getAppraisalbehaviours($comp->Line_No))) {

                    foreach ($model->getAppraisalbehaviours($comp->Line_No) as $be) :  ?>
                        <tr>
                            <td><?= isset($be->Behaviour_Name) ? $be->Behaviour_Name : 'Not Set' ?></td>
                            <td><?= !empty($be->Weight) ? $be->Weight : '' ?></td>


                            <td><?= !empty($be->Mid_Year_Employee_Rating) ? $be->Mid_Year_Employee_Rating : '' ?></td>
                            <td><?= !empty($be->Mid_Year_Employee_Comments) ? $be->Mid_Year_Employee_Comments : '' ?></td>
                            <td><?= !empty($be->Mid_Year_Supervisor_Rating) ? $be->Mid_Year_Supervisor_Rating : '' ?></td>
                            <td><?= !empty($be->Mid_Year_Supervisor_Comments) ? $be->Mid_Year_Supervisor_Comments : '' ?></td>
                            <td data-key="<?= $be->Key ?>" data-name="Mid_Year_Agreement" data-service="EmployeeAppraisalBehaviours" ondblclick="addInput(this,'checkbox')"><?= ($be->Mid_Year_Agreement) ? 'Yes' : 'No' ?></td>
                            <td data-key="<?= $be->Key ?>" data-name="Mid_Year_Disagreement_Comments" data-service="EmployeeAppraisalBehaviours" ondblclick="addTextarea(this)"><?= !empty($be->Mid_Year_Disagreement_Comments) ? $be->Mid_Year_Disagreement_Comments : '' ?></td>


                            <td><?= !empty($be->Self_Rating) ? $be->Self_Rating : '' ?></td>
                            <td><?= !empty($be->Appraisee_Remark) ? $be->Appraisee_Remark : '' ?></td>
                            <td><?= !empty($be->Appraiser_Rating) ? $be->Appraiser_Rating : '' ?></td>


                            <td><?= !empty($be->Overall_Remarks) ? $be->Overall_Remarks : '' ?></td>
                            <td><?= ($be->Agree) ? 'Yes' : 'No' ?></td>
                            <td><?= !empty($be->Disagreement_Comments) ? $be->Disagreement_Comments : '' ?></td>
                        </tr>
                <?php
                    endforeach;
                }
                ?>
            </tbody>
        </table>
    </td>
</tr>