/* file generation UUID: 59f0c0a8ec95f */

--
-- Auditing triggers for communication
--

CREATE OR REPLACE FUNCTION communication_audf() RETURNS TRIGGER AS
$functionBlock$
    BEGIN
        IF (TG_OP = 'UPDATE') THEN
            NEW.record_version = COALESCE(NEW.record_version,1)+1;
            NEW.update_date = NOW();
            NEW.update_user_id = core.get_logged_user();
        ELSIF (TG_OP = 'INSERT') THEN
            NEW.record_version = 1;
            NEW.creation_date = COALESCE( NEW.creation_date, NOW() );
            NEW.creation_user_id = COALESCE( NEW.creation_user_id, core.get_logged_user() );
        END IF;
        RETURN NEW;
    END;
$functionBlock$
LANGUAGE plpgsql;

CREATE TRIGGER communication_audf_trg BEFORE INSERT OR UPDATE ON communication
    FOR EACH ROW EXECUTE PROCEDURE communication_audf();


