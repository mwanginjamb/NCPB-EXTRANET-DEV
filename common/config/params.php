<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'customer@softeboard.com',
    'senderEmail' => 'customer@softeboard.com',
    'senderName' => 'HRMIS mailer',
    'user.passwordResetTokenExpire' => 3600,
    'powered' => 'Iansoft Ltd',
    'NavisionUsername'=>'Administrator',
    'NavisionPassword'=>'bjU8a72nRPgmWh',
    'generalTitle' => 'NCPB EXTRANET ',


    'NavTestApprover' => 'Approver',
    'NavTestApproverPassword' => '@Approver123',

    'server'=>'vmi455998',//'app-svr-dev.rbss.com',//Navision Server
    'WebServicePort'=>'10047',//Nav server Port
    'ServerInstance'=>'DynamicsNAV100',//Nav Server Instance
    'ServiceCompanyName'=>'NCPB',//Nav Company,
    'DbCompanyName' => 'NCPB$',
    'ldPrefix'=>'vmi455998',//ACTIVE DIRECTORY prefix
    'adServer' => 'KRB-SVR7.KRBHQS.GO.KE', //Active directory domain controller

    //sharepoint config
    'sharepointUrl' => 'https://ackads.sharepoint.com',
    'sharepointUsername' => 'francis@ackads.onmicrosoft.com',
    'sharepointPassword' => '@crm1220#*',
    'library' => 'Mydocs',
    'clientID' => '7e92ce54-e4bf-491a-bef6-eb94044ce297',
    'clientSecret' => 'Q6UJkB3bRlPkGBjWNgrQVCyyjL2vgi5rtP7THpLwJ+s=',

    'profileControllers' => [
        'applicantprofile',
        'experience',
        'qualification',
        'hobby',
        'language',
        'referee',
        'recruitment',
        'employeerequisition'
    ],
    'codeUnits' => [
       'IntegrationFuctions' => 'IntegrationFuctions', // 51000
        'AppraisalStatusChange' => 'AppraisalStatusChange', //50020
    ],
    'ServiceName'=>[

        'EmployeeCard' => 'EmployeeCard', // 5200
        'EmployeeList' => 'EmployeeList',// 5201
        'EthnicGroups' => 'EthnicGroups', //70409
        'Regions' => 'Regions', // 50112
        'Stations' => 'Stations', //70410
        'Counties' => 'Counties', // 50334
        'SubCounties' => 'SubCounties', // 50335
        /******************************NCPB LEAVE************************************/
        'LeaveApplicationList' => 'LeaveApplicationList', // 70053
        'LeaveApplicationHeader' => 'LeaveApplicationHeader', //70075
        'LeaveApplicationLines' => 'LeaveApplicationLines',//70055
        'LeaveTypesSetup' => 'LeaveTypesSetup', //50076


        /******************************END NCPB LEAVE************************************/

        'RequestsToApprove' => 'RequestsToApprove', //654---------------duplicated
        'ApprovalComments' => 'ApprovalComments', //660
        'RejectedApprovalEntries' => 'RejectedApprovalEntries', //50003

        'RequisitionEmployeeList' => 'RequisitionEmployeeList',//70029
        'RequisitionEmployeeCard' => 'RequisitionEmployeeCard',//70028
        'JobsList' => 'JobsList',//70009
        'JobsCard' => 'JobsCard',//70002
        'JobApplicantProfile' => 'JobApplicantProfile', //50001
        'applicantProfile' => 'applicantProfile',//50001
        'referees' => 'referees',//55060
        'applicantLanguages' => 'applicantLanguages', //55061
        'experience' => 'experience', //55062
        'hobbies' => 'hobbies', //55063
        'qualifications' => 'qualifications',//55064
        'JobResponsibilities' => 'JobResponsibilities',//69000 -->specs
        'JobRequirements' => 'JobRequirements', //69001 ---> specs
        'JobExperience' => 'JobExperience',//69004
        'HRqualifications' => 'HRqualifications', //5205
        'JobApplicantRequirementEntries' => 'JobApplicantRequirementEntries', //55065

        'Countries' => 'Countries', //10

        'ItemList' => 'ItemList', //31
        'LocationList' => 'LocationList', //15
        'VendorList' => 'VendorList', //27
        'ContractList' => 'ContractList', //60029
        'ContractCard' => 'ContractCard', //60030
        'ContractLines' => 'ContractLines', //60031
        'PurchaseOrderList' => 'PurchaseOrderList', //9307
        'RFQList' => 'RFQList',// 50045


        

        //-------------NCPB Appraisal--------------------------------------------------------------------------------

        'AppraisalList' => 'AppraisalList', //60007
        'AppraisalCard' => 'AppraisalCard', //60008
        'EmployeeAppraisalKRAs' => 'EmployeeAppraisalKRAs', //60009
        'EmployeeAppraisalKPIs' => 'EmployeeAppraisalKPIs', //60010
        'ScoreCards' => 'ScoreCards', //60011
        'AppraisalListSupervisor' => 'AppraisalListSupervisor', //60012
        'AppraisalListHr' => 'AppraisalListHr', //60013
        'AppraisalListClosed' => 'AppraisalListClosed', //60014
        'AppraisalListExtraSupervisor' => 'AppraisalListExtraSupervisor', //60015
        'ApprovedAppraisals' => 'ApprovedAppraisals', //60016
        'ApprovedAppraisalCard' => 'ApprovedAppraisalCard', //60017
        'ApprovedAppraisalKRAs' => 'ApprovedAppraisalKRAs', //60018
        'ApprovedKPIs' => 'ApprovedKPIs', //60019
        'KPIAttachments' => 'KPIAttachments', //60020
        'KRALookup'=> 'KRALookup', //60046 KRALookup
        'PerspectiveObjectives' => 'PerspectiveObjectives', //60001

        'AppraisalStatusChange' => 'AppraisalStatusChange', // Code Unit
        'AppraisalManagement' => 'AppraisalManagement', // 60000 Code Unit

        /*End Appraisal service declaration*/


        //Payslip report
        'Payrollperiods' => 'Payrollperiods', //70255

        //P9 report

        'P9YEARS' => 'P9YEARS', //70286


        /**************************IMPREST*************************************/
        'ImprestRequestList' => 'ImprestRequestList', //50138 (Page)
        'ImprestRequestCard' => 'ImprestRequestCard', //50139 (Page)
        'ImprestRequestLine' => 'ImprestRequestLine', // 50140 (Page)
        'PaymentMethods' => 'PaymentMethods', //427 (Page)
        'AccountList' => 'AccountList', //18 (Page)
        'PostedImprest' => 'PostedImprest', // 50031 (Page)
        'SurrenderCard' => 'SurrenderCard', // 50032 (Page)
        'SurrenderLines' => 'SurrenderLines', //50037 (Page)
        'Dimensions' => 'Dimensions', // 560
        'PostCodes' => 'PostCodes', //367
        'Currencies' => 'Currencies', //5

        /* Integration Code Unit*/

        'IntegrationFuctions' => 'IntegrationFuctions', //(Code Unit)51000


       
    ],
    'QualificationsMimeTypes' => [

        'application/pdf',

    ],
    'Microsoft' => [
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'application/vnd.ms-word.document.macroEnabled.12',
        'application/vnd.ms-word.template.macroEnabled.12',
        'application/vnd.ms-excel',
        'application/vnd.ms-excel',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'application/vnd.ms-excel.sheet.macroEnabled.12',
        'application/vnd.ms-excel.template.macroEnabled.12',
        'application/vnd.ms-excel.addin.macroEnabled.12',
        'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'application/vnd.ms-powerpoint',
        'application/vnd.ms-powerpoint',
        'application/vnd.ms-powerpoint',
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/vnd.openxmlformats-officedocument.presentationml.template',
        'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'application/vnd.ms-powerpoint.addin.macroEnabled.12',
        'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
        'application/vnd.ms-powerpoint.template.macroEnabled.12',
        'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
        'application/vnd.ms-access',
        'application/rtf',
        'application/octet-stream'
    ],

    'Documents' => [
        'Purchase Requisition' => 1,
        'Transfer Order' => 2,
        'Imprest' => 3,
        'Surrender' => 4,
        'Fleet Request' => 5,
        'Payment Voucher' => 6,
        'Bank Transfer' => 7,
        'SAF' => 8,
        'Service Order' => 9,
        'GRV' =>  10,
        'GIV' => 11,
        'Appraisal' => 12,
        'Leave' =>  13,
        'Safari' => 14,
        'Store Requisition' => 15,
        'Claim' => 16,
        'GRN' => 17,
        'SCM' => 18,
        'SO' => 19,
        'PCM' => 20,
        'PO' => 21,
        'JV' => 22,
        'PI' => 23,
        'SI' => 24,
        'P. Variation' =>  25,
        'Stk. Maint.' => 26,
        'Port Pass' =>  27,
        'Lease' => 28,
        'Leave Adj.' => 29
    ],

];
