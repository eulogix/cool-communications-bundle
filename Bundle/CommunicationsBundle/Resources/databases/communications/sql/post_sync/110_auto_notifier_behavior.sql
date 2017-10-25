/* file generation UUID: 59f0c0a8ec95f */

--
-- Notifier triggers for communication
--

CREATE OR REPLACE FUNCTION communication_notf() RETURNS TRIGGER AS
$functionBlock$
    BEGIN
        PERFORM pg_notify('datachange_communication', '{ "schema": "communications", "actual_schema": "' || TG_TABLE_SCHEMA || '", "operation": "' || TG_OP || '" }' );
        PERFORM pg_notify(TG_TABLE_SCHEMA || ';' || 'datachange_communication',  '{ "schema": "communications", "actual_schema": "' || TG_TABLE_SCHEMA || '", "operation": "' || TG_OP || '" }');
        RETURN NULL;
    END;
$functionBlock$
LANGUAGE plpgsql;

CREATE TRIGGER communication_notf_notf_trg AFTER INSERT OR UPDATE OR DELETE OR TRUNCATE ON communication
    FOR EACH STATEMENT EXECUTE PROCEDURE communication_notf();


