public class MasterUsersMapUpdateSqlGenerator {

	public static void main(String[] args) {
		String databases[] = new String[] {
			"ahn_f4s_uat",
			"ahn_scc_uat",
			"dod_asb_uat",
			"ed_ens_uat",
			"mmg_chet_lilly_uat",
			"mmg_chet_otsuka_uat",
			"mmg_jcc_uat",
			"mmg_lilly_uat",
			"mmg_otsuka_uat",
			"mmg_t2d_uat",
			"mmg_ysc_uat",
			"nami_sd_uat",
			"pfizer_ra_uat",
			"ahn_f4s_production",
			"ahn_scc_production",
			"dod_asb_production",
			"mmg_jcc_production",
			"mmg_lilly_production",
			"mmg_otsuka_production",
			"mmg_t2d_production",
			"mmg_ysc_production",
			"mr_demo_production",
			"nami_sd_production",
			"pfizer_ra_production",
		};

		String sqlTemplate = "UPDATE `{{database}}`.`master_users_map` AS `mum`\n" +
				"JOIN `{{database}}`.`master_organizations_bak` AS `mob`\n" +
				"\tON `mob`.`id` = `mum`.`organization_id`\n" +
				"SET `mum`.`organization_id` = CASE\n" +
				"\tWHEN `mob`.`organization_name` = 'DoD' THEN (SELECT `id` FROM `{{database}}`.`master_organizations` WHERE `name` = 'Department of Defense')\n" +
				"\tWHEN `mob`.`organization_name` = 'Enersource' THEN (SELECT `id` FROM `{{database}}`.`master_organizations` WHERE `name` = 'Enersource')\n" +
				"\tWHEN `mob`.`organization_name` = 'Fit For Surgery' THEN (SELECT `id` FROM `{{database}}`.`master_organizations` WHERE `name` = 'Allegheny Health Network')\n" +
				"\tWHEN `mob`.`organization_name` = 'Lilly JCC' THEN (SELECT `id` FROM `{{database}}`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')\n" +
				"\tWHEN `mob`.`organization_name` = 'Lilly JPBL' THEN (SELECT `id` FROM `{{database}}`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')\n" +
				"\tWHEN `mob`.`organization_name` = 'Medrespond' THEN (SELECT `id` FROM `{{database}}`.`master_organizations` WHERE `name` = 'MedRespond')\n" +
				"\tWHEN `mob`.`organization_name` = 'NAMI SD' THEN (SELECT `id` FROM `{{database}}`.`master_organizations` WHERE `name` = 'NAMI San Diego')\n" +
				"\tWHEN `mob`.`organization_name` = 'Otsuka' THEN (SELECT `id` FROM `{{database}}`.`master_organizations` WHERE `name` = 'Otsuka')\n" +
				"\tWHEN `mob`.`organization_name` = 'Pfizer PRA' THEN (SELECT `id` FROM `{{database}}`.`master_organizations` WHERE `name` = 'Pfizer')\n" +
				"\tWHEN `mob`.`organization_name` = 'Pfizer PRB' THEN (SELECT `id` FROM `{{database}}`.`master_organizations` WHERE `name` = 'Pfizer')\n" +
				"\tWHEN `mob`.`organization_name` = 'Pfizer PRC' THEN (SELECT `id` FROM `{{database}}`.`master_organizations` WHERE `name` = 'Pfizer')\n" +
				"\tWHEN `mob`.`organization_name` = 'Pfizer YSC' THEN (SELECT `id` FROM `{{database}}`.`master_organizations` WHERE `name` = 'Pfizer')\n" +
				"\tWHEN `mob`.`organization_name` = 'Supportive Care' THEN (SELECT `id` FROM `{{database}}`.`master_organizations` WHERE `name` = 'Allegheny Health Network')\n" +
				"\tWHEN `mob`.`organization_name` = 'T2D' THEN (SELECT `id` FROM `{{database}}`.`master_organizations` WHERE `name` = 'Merck')\n" +
				"\tELSE `mum`.`organization_id`\n" +
				"END;";

		for(int i = 0; i < databases.length; i++) {
			System.out.println(sqlTemplate.replaceAll("\\{\\{database\\}\\}", databases[i]));
		}

		System.exit(0);
	}

}
