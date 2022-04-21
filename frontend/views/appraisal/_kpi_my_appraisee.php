
<tr class="child">
                                            <td colspan="11" >
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-borderless table-info">
                                                        <thead>
                                                        <tr >                                                          
                                                            
                                                            <td class="text text-bold text-center">KPI</td>
                                                            <td class="text text-bold text-center">Target</td>
                                                            <td class="text text-bold text-center">Weight</td>
                                                            <td class="text text-bold text-center text-info">Mid_Year Appraisee Assesment</td>
                                                            <td class="text text-bold text-center">Mid_Year Appraisee Comments</td>
                                                            <td class="text text-bold text-center">Mid_Year Supervisor Assesment</td>
                                                            <td class="text text-bold text-center">Mid_Year Supervisor Comments</td>
                                                            <td class="text text-bold text-center">Appraisee Self_Rating</td>
                                                            <td class="text text-bold text-center">Employee Comments</td>
                                                            <td class="text text-bold text-center">Appraiser Rating</td>
                                                            <td class="text text-bold text-center">End_Year Supervisor_Comments</td>
                                                            <td class="text text-bold text-center">Agree</td>
                                                            <td class="text text-bold text-center">Disagreement Comments</td>                                                    
                                                            <td class="text text-bold text-center">Non-Achievement Reasons</td>
                                                            <td class="text text-bold text-center">Target Status</td>
                                                            <td class="text text-bold text-center">Mid Year Agreement</td>
                                                            <td class="text text-bold text-center">Mid Year Disagreement Comment</td>                                                       
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php if(is_array($model->getKPI($k->Line_No))){
                                                            foreach($model->getKPI($k->Line_No) as $kpi):
        
                                                                     $agree = ($kpi->Agree)?'Yes':'No';
                                                                     $Myagreement = ($kpi->Mid_Year_Agreement)?'Yes':'No';
                                                             ?>
                                                                <tr>                                                                   
                                                        
                                                                    <td><?= !empty($kpi->KPI)?$kpi->KPI:'' ?></td>
                                                                    <td><?= !empty($kpi->Target)?$kpi->Target:'' ?></td>
                                                                    <td><?= !empty($kpi->Weight)?$kpi->Weight:'' ?></td>
                                                                    <td data-key="<?= $kpi->Key ?>" data-name="Mid_Year_Appraisee_Assesment" data-service="EmployeeAppraisalKPIs" ondblclick="addDropDown(this,'ratings')"><?= !empty($kpi->Mid_Year_Appraisee_Assesment)?$kpi->Mid_Year_Appraisee_Assesment:'' ?></td>
                                                                    <td data-key="<?= $kpi->Key ?>" data-name="Mid_Year_Appraisee_Comments" data-service="EmployeeAppraisalKPIs" ondblclick="addTextarea(this)"><?= !empty($kpi->Mid_Year_Appraisee_Comments)?$kpi->Mid_Year_Appraisee_Comments:'' ?></td>
                                                                    <td data-key="<?= $kpi->Key ?>" data-name="Mid_Year_Supervisor_Assesment" data-service="EmployeeAppraisalKPIs" ondblclick="addDropDown(this,'ratings')"><?= !empty($kpi->Mid_Year_Supervisor_Assesment)?$kpi->Mid_Year_Supervisor_Assesment:'' ?></td>
                                                                    <td data-key="<?= $kpi->Key ?>" data-name="Mid_Year_Supervisor_Comments" data-service="EmployeeAppraisalKPIs" ondblclick="addTextarea(this)"><?= !empty($kpi->Mid_Year_Supervisor_Comments)?$kpi->Mid_Year_Supervisor_Comments:'' ?></td>
                                                                    <td data-key="<?= $kpi->Key ?>" data-name="Appraisee_Self_Rating" data-service="EmployeeAppraisalKPIs" ondblclick="addDropDown(this,'ratings')"><?= !empty($kpi->Appraisee_Self_Rating)?$kpi->Appraisee_Self_Rating:'' ?></td>
                                                                    <td data-key="<?= $kpi->Key ?>" data-name="Employee_Comments" data-service="EmployeeAppraisalKPIs" ondblclick="addTextarea(this)"><?= !empty($kpi->Employee_Comments)?$kpi->Employee_Comments:'' ?></td>
                                                                    <td data-key="<?= $kpi->Key ?>" data-name="Appraiser_Rating" data-service="EmployeeAppraisalKPIs" ondblclick="addDropDown(this,'ratings')"><?= !empty($kpi->Appraiser_Rating)?$kpi->Appraiser_Rating:'' ?></td>
                                                                    <td data-key="<?= $kpi->Key ?>" data-name="End_Year_Supervisor_Comments" data-service="EmployeeAppraisalKPIs" ondblclick="addTextarea(this)"><?= !empty($kpi->End_Year_Supervisor_Comments)?$kpi->End_Year_Supervisor_Comments:'' ?></td>
                                                                    <td data-key="<?= $kpi->Key ?>" data-name="Agree" data-service="EmployeeAppraisalKPIs" ondblclick="addInput(this,'checkbox')"><?= !empty($agree)?$agree:'' ?></td>
                                                                    <td data-key="<?= $kpi->Key ?>" data-name="Disagreement_Comments" data-service="EmployeeAppraisalKPIs" ondblclick="addTextarea(this)"><?= !empty($kpi->Disagreement_Comments)?$kpi->Disagreement_Comments:'' ?></td> 
                                                                    <td data-key="<?= $kpi->Key ?>" data-name="Non_Achievement_Reasons" data-service="EmployeeAppraisalKPIs" ondblclick="addTextarea(this)"><?= !empty($kpi->Non_Achievement_Reasons)?$kpi->Non_Achievement_Reasons:'' ?></td>
                                                                    <td data-key="<?= $kpi->Key ?>" data-name="Target_Status" data-service="EmployeeAppraisalKPIs" ondblclick="addDropDown(this,'target-status')"><?= !empty($kpi->Target_Status)?$kpi->Target_Status:'' ?></td>
                                                                    <td data-key="<?= $kpi->Key ?>" data-name="Mid_Year_Agreement" data-service="EmployeeAppraisalKPIs" ondblclick="addInput(this,'checkbox')"><?= $Myagreement ?></td>
                                                                    <td data-key="<?= $kpi->Key ?>" data-name="Mid_Year_Disagreement_Comment" data-service="EmployeeAppraisalKPIs" ondblclick="addTextarea(this)"><?= !empty($kpi->Mid_Year_Disagreement_Comment)?$kpi->Mid_Year_Disagreement_Comment:'' ?></td>
                                                                   
                                                                </tr>
                                                                <?php
                                                            endforeach;
                                                        }
                                                        ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </td>
                                        </tr>