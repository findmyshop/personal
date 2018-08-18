(
    SELECT
        'ahn_f4s_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM ahn_f4s_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'ahn_ppd_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM ahn_ppd_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'ahn_scc_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM ahn_scc_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'az_ddk_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM az_ddk_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'bcran_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM bcran_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'ddi_tss_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM ddi_tss_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'dod_asb_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM dod_asb_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'ed_ens_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM ed_ens_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'exc_epr_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM exc_epr_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'f4s_white_label_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM f4s_white_label_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'mmg_alz_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM mmg_alz_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'mmg_jcc_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM mmg_jcc_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'mmg_lilly_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM mmg_lilly_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'mmg_msp_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM mmg_msp_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'mmg_otsuka_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM mmg_otsuka_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'mmg_t2d_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM mmg_t2d_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'mmg_ysc_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM mmg_ysc_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'mr_demo_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM mr_demo_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'mr_sbirt_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM mr_sbirt_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'nami_sd_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM nami_sd_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'nami_white_label_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM nami_white_label_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'ons_oct_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM ons_oct_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
) UNION (
    SELECT
        'rush_sbirt_production' AS experience,
        ip_address,
        COUNT(DISTINCT session_id) AS sessions_count
    FROM rush_sbirt_production.master_activity_logs
    GROUP BY ip_address
    ORDER BY COUNT(DISTINCT session_id) DESC
)
ORDER BY experience ASC, sessions_count DESC