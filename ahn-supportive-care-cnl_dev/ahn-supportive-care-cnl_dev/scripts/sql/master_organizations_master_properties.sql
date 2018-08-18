-- sql to select organization - property mappings
select
	mo.name,
	group_concat(mp.name) AS associated_properties
from master_organizations as mo
join master_organization_property_map as mopm
	on mopm.organization_id = mo.id
join master_properties as mp
	on mp.id = mopm.property_id
where mo.active = 1
	and mopm.active = 1
	and mp.active = 1
group by mo.id;