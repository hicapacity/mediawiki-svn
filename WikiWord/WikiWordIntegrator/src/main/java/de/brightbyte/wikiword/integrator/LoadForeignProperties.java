package de.brightbyte.wikiword.integrator;

import java.io.IOException;

import de.brightbyte.data.cursor.DataCursor;
import de.brightbyte.util.PersistenceException;
import de.brightbyte.wikiword.integrator.data.FeatureSet;
import de.brightbyte.wikiword.integrator.data.ForeignEntity;
import de.brightbyte.wikiword.integrator.data.ForeignEntityCursor;
import de.brightbyte.wikiword.integrator.processor.ForeignPropertyPassThrough;
import de.brightbyte.wikiword.integrator.processor.ForeignPropertyProcessor;
import de.brightbyte.wikiword.integrator.store.DatabaseForeignPropertyStoreBuilder;
import de.brightbyte.wikiword.integrator.store.ForeignPropertyStoreBuilder;
import de.brightbyte.wikiword.store.WikiWordStoreFactory;

/**
 * This is the primary entry point to the first phase of a WikiWord analysis.
 * ImportDump can be invoked as a standalone program, use --help as a
 * command line parameter for usage information.
 */
public class LoadForeignProperties extends AbstractIntegratorApp<ForeignPropertyStoreBuilder, ForeignPropertyProcessor, ForeignEntity> {
	
	@Override
	protected WikiWordStoreFactory<? extends ForeignPropertyStoreBuilder> createConceptStoreFactory() throws IOException, PersistenceException {
		return new DatabaseForeignPropertyStoreBuilder.Factory(getTargetTableName(), getConfiguredDataset(), getConfiguredDataSource(), tweaks);
	}

	@Override
	protected void run() throws Exception {
		ForeignPropertyStoreBuilder store = getStoreBuilder();
		this.propertyProcessor = createProcessor(store); //FIXME
		
		section("-- fetching properties --------------------------------------------------");
		DataCursor<FeatureSet> fsc = openFeatureSetCursor();
		DataCursor<ForeignEntity> cursor = new ForeignEntityCursor(fsc, sourceDescriptor.getAuthorityName(), sourceDescriptor.getPropertySubjectField(), sourceDescriptor.getPropertySubjectNameField());
		
		section("-- process properties --------------------------------------------------");
		store.prepareImport();
		
		this.propertyProcessor.processProperties(cursor);
		cursor.close();

		store.finalizeImport();
	}	

	@Override
	protected ForeignPropertyProcessor createProcessor(ForeignPropertyStoreBuilder conceptStore) throws InstantiationException {
		//		FIXME: parameter list is restrictive, pass descriptor 
		ForeignPropertyProcessor processor = instantiate(sourceDescriptor, "foreignPropertyProcessorClass", ForeignPropertyPassThrough.class, conceptStore);

		if (processor instanceof ForeignPropertyPassThrough) {
			String qualifier = sourceDescriptor.getTweak("property-qualifier", null);
			if (qualifier!=null) ((ForeignPropertyPassThrough)processor).setQualifier(qualifier);
		}
		
		return processor;
	}

	public static void main(String[] argv) throws Exception {
		LoadForeignProperties app = new LoadForeignProperties();
		app.launch(argv);
	}
}