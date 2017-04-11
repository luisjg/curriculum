CREATE OR REPLACE
  SQL SECURITY INVOKER
VIEW `curriculum`.`people`
AS SELECT 
     nemo.individuals.individuals_id,
     nemo.entities.parent_entities_id,
     nemo.entities.record_status,
     nemo.individuals.first_name,
     nemo.individuals.middle_name,
     nemo.individuals.last_name,
     nemo.individuals.common_name,
     bedrock.registry.email
FROM nemo.individuals JOIN nemo.entities 
     ON  nemo.individuals.individuals_id = nemo.entities.entities_id 
     JOIN  bedrock.registry USING (entities_id);