public class MasterOrganizationPropertyMapSqlGenerator {

	public static void main(String[] args) {
		String str[][] = new String[][] {
			{"ahn_f4s_uat", "Allegheny Health Network", "f4s"},
			{"ahn_scc_uat", "Allegheny Health Network", "scc"},
			{"dod_asb_uat", "Department of Defense", "dod"},
			{"ed_ens_uat", "Enersource", "ens"},
			{"mmg_chet_lilly_uat", "Eli Lilly and Company", "lilly"},
			{"mmg_chet_otsuka_uat", "Otsuka", "otsuka"},
			{"mmg_jcc_uat", "Eli Lilly and Company", "jcc"},
			{"mmg_lilly_uat", "Eli Lilly and Company", "lilly"},
			{"mmg_otsuka_uat", "Otsuka", "otsuka"},
			{"mmg_t2d_uat", "Merck", "t2d"},
			{"mmg_ysc_uat", "Pfizer", "ysc"},
			{"nami_sd_uat", "NAMI San Diego", "nsd"},
			{"pfizer_ra_uat", "Pfizer", "pra"},
			{"pfizer_ra_uat", "Pfizer", "prb"},
			{"pfizer_ra_uat", "Pfizer", "prc"},
			{"ahn_f4s_production", "Allegheny Health Network", "f4s"},
			{"ahn_scc_production", "Allegheny Health Network", "scc"},
			{"dod_asb_production", "Department of Defense", "dod"},
			{"mmg_jcc_production", "Eli Lilly and Company", "jcc"},
			{"mmg_lilly_production", "Eli Lilly and Company", "lilly"},
			{"mmg_otsuka_production", "Otsuka", "otsuka"},
			{"mmg_t2d_production", "Merck", "t2d"},
			{"mr_demo_production", "MedRespond", "default"},
			{"nami_sd_production", "NAMI San Diego", "nsd"},
			{"pfizer_ra_production", "Pfizer", "pra"},
			{"pfizer_ra_production", "Pfizer", "prb"},
			{"pfizer_ra_production", "Pfizer", "prc"}
		};

		for(int r = 0; r < str.length; r++) {
			System.out.printf("INSERT INTO `%s`.`master_organization_property_map` (\n\t`organization_id`,\n\t`property_id`\n) VALUES (\n\t(SELECT `id` FROM `%s`.`master_organizations` WHERE `name` = 'MedRespond'),\n\t(SELECT `id` FROM `%s`.`master_properties` WHERE `name` = '%s')\n);\n", str[r][0], str[r][0], str[r][0], str[r][2]);
			System.out.printf("INSERT INTO `%s`.`master_organization_property_map` (\n\t`organization_id`, \n\t`property_id`\n) VALUES (\n\t(SELECT `id` FROM `%s`.`master_organizations` WHERE `name` = '%s'),\n\t(SELECT `id` FROM `%s`.`master_properties` WHERE `name` = '%s')\n);\n", str[r][0], str[r][0], str[r][1], str[r][0], str[r][2]);
		}

		System.exit(0);
	}

}
