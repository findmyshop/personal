(
    SELECT
        'ahn_f4s_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM ahn_f4s_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'ahn_ppd_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM ahn_ppd_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'ahn_scc_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM ahn_scc_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'az_ddk_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM az_ddk_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'bcran_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM bcran_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'ddi_tss_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM ddi_tss_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'dod_asb_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM dod_asb_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'ed_ens_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM ed_ens_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'exc_epr_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM exc_epr_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'f4s_white_label_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM f4s_white_label_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'mmg_alz_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM mmg_alz_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'mmg_jcc_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM mmg_jcc_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'mmg_lilly_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM mmg_lilly_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'mmg_msp_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM mmg_msp_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'mmg_otsuka_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM mmg_otsuka_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'mmg_t2d_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM mmg_t2d_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'mmg_ysc_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM mmg_ysc_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'mr_demo_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM mr_demo_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'mr_sbirt_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM mr_sbirt_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'nami_sd_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM nami_sd_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'nami_white_label_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM nami_white_label_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'ons_oct_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM ons_oct_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
) UNION (
    SELECT
        'rush_sbirt_production' AS experience,
        STD(sessions_count) AS sessions_count_standard_deviation,
        AVG(sessions_count) AS average_sessions_count,
        MIN(sessions_count) AS min_sessions_count,
        MAX(sessions_count) AS max_sessions_count
        FROM (
            SELECT
                COUNT(DISTINCT session_id) AS sessions_count
            FROM rush_sbirt_production.master_activity_logs
        GROUP BY ip_address
    ) AS session_counts
)