<!--  * Laboratory Information Indexing System
 *
 * An open source mini LIMS for metadata organisation and archival purposes
 *
 * @author      Matt Forster / @frostyforster
 * @copyright   Copyright (c) 2013, Matthew S. Forster
 * @license     MIT (./license.txt)
 * @link        http://github.com/forstermatth/liis
 * @since       Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Main Help Content
 *
 * The markdown content for the main help page
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */ -->


## Help

### Content

- [Sample vs. Culture](#sampcult)
- [Searching](#searching)
- [Filters for Sample](#sampfilters)
- [Filters for Culture](#cultfilters)
- [View](#view)
- [Create](#create)
- [Template](#template)
- [Edit](#edit)
- [Images](#images)
- [Import](#import)
- [Export](#export)
- [Bugs](#bugs)
- [About](#about)

<h3 id="sampcult">Sample vs. Culture:</h3>

Clicking on **Sample** or **Culture** on the top navigation bar will switch between the two contexts that exist in the application. This is persistent across all pages indicated by a colour change and includes any buttons. Ensure you are in the correct database before making any changes.

Sample database is used as the default and is colour coded with blue.
Culture database is colour coded with green.

<h3 id="searching">Searching:</h3>

The search bar requires specific keywords or partial information to work effectively.

It supports **multiple words** with **spaces as the delimiter**. The order is predefined and is important to remember to utilize the search effectively. The order of the search keywords depends on the [filter][1] selected. Dashes ( - ) can be used as **placeholders** to skip a keyword.

*Example Search*: **es\_bl 264 solid 2** or **es\_bl - solid 2**.

You can see that "es_bl" is a keyword for the experiment ID and that the order stays the same for both. A dash ( - ) replaces the "264" in sample ID in order to specify we are looking for all samples in the experiment with type "solid" in period "2".

Entering only a **single keyword** will search all of the fields appropriate for the filter selected and return any results that **match exactly**. 
Using the percent ( % ) (wildcard) allows you to search all tables using partial information.
Placing the percent ( % ) (wildcard) **before or after the partial data** will search with that information either at the end or begining of all records.

*Example Search*: **es% %6% solid 2**.

You can see that "es%" is partial information for the experiment ID. A percent ( % ) on both sides of the six "%6%" replaces the "264" in sample ID to find *all records* containing a six matching with type "solid" in period "2".

[1]: #sampfilters

<h3 id="sampfilters">Filters for Sample:</h3>

**Under the search bar** are filters that can be selected using the radio button beside them.

*  **Sample** searches: *Experiment ID, Sample ID, Type, Period, Storage Location, Date, Notes* in that order, using a single keyword or dashes as placeholders. Up to 7 keywords can be used.
* **Date** searches: *Year, Month, Day* in that order using a single set of digits. Only two words (one space) is allowed in date searches.
	- A **date range** can be searched using: *yyyy-mm-dd yyyy-mm-dd* for a set of inclusive dates. **Zeros** can be used as place holders.
	- Example Date Searches: 
		- "2012-09-1 2012-11-31"
		- "2009 2012-12" *all dates from the start of 2009 and the end of 2012. The month must be present to search the whole year.*
		- "2008-0 2010-0" *all dates from the start of 2008 to the end of 2009, no dates in 2010 are included.*
* **Source** searches: *Number, Type, Subtype, Treatment* in that order using a single keyword or dashes as placeholders. Up to 4 keywords can be used.
* **Site** searches: *Site, Subsite* in that order using a single keyword or dashes as placeholders. Up to 2 keywords can be used.

<h3 id="cultfilters">Filters for Culture:</h3>

**Under the search bar** are **filters** that can be selected using the radio button beside them.

* **Culture** searches: *Lab Number, Reference Number, GenBank Number, Storage Location, Owner, Date, Notes* in that order using a single keyword or dashes as placeholders. Up to 7 keywords can be used.
* **Date** searches: *Year, Month, Day* in that order using a single set of digits. Only two words (one space) is allowed in date searches.
	- A **date range** can be searched using: *yyyy-mm-dd yyyy-month-dd* for a set of inclusive dates. **Zeros** can be used as place holders but the range must be completed fully.
	- Example Date Search: "2012-09-0 2012-11-31" will return all results from that year within september and october.
* **Strain** searches: *Strain, Species, Genus* in that order using a single keyword. Using dashes as placeholders you can search:
*Strain, Species, Genus, Family, Order, Class, Phylum, Kingdom, Domain* in that order.

<h3 id="view">View:</h3>

View Button allows you to see the specific details of a selected query. After completing a search, **click once on the row** of information you desire, then press the **view button** . This will take you to a new page that will show all the details of the search that you selected. Details are ordered into groups and can be expanded and collapsed for easy reading.

<h3 id="create">Create:</h3>

The create button will take you to a **new form** for creating a new culture or sample record, depending on what database you have selected. See [Sample vs. Culture][1].

[1]: #sampcult

<h3 id="template">Template:</h3>

Takes the existing record that you are veiwing and moves all the **data into a new form**. This form can then be edited as needed to create a **record similar but different** from its original.

<h3 id="Edit">Edit:</h3>

Edit takes the record you are viewing and moves it to a form. The **form can then be edited** as needed to change that specific record information.

<h3 id="images">Images:</h3>

**Clicking an image** will open a larger view in a new window. Cultures have an image and some DNA/RNA extractions will have an image with them. These can be viewed by first selecting the DNA/RNA expand view and then clicking the thumbnail.

**Uploading an image** can be done on the record view page. Cultures offer the option to upload an image to the culture, as well as the DNA/RNA records attached. Samples offer the DNA/RNA upload in their view pages.

<h3 id="import">Import:</h3>

Importing records can be done from each of the main search pages of the application. Please note that each context (sample, culture) imports that type of record exclusively.

The template for importing can be found on the import page, and it is important not to alter it.

- [Culture Import Template](/resources/download/LIIS_culture_import.TEMPLATE.csv)
- [Sample Import Template](/resources/download/LIIS_sample_import.TEMPLATE.csv)

As a rule, the fields are required to be unaltered for the import function to accept them, and the second line of the file is always ignored as it is reserved for the field descriptions.

<h3 id="export">Export:</h3>

Exporting records can be done from each of the main search pages of the application. Please note that each context (sample, culture) exports that type of record exclusively.

The sample export provides a list of projects that can be exported, and will export the full project that is selected.

The culture export provides an input where the lab number of the culture can be provided. Full and partial (with the wildcard '%') identifiers are supported.
*Use a partial labnumber to export multiple culture records*.

<h3 id="bugs">Bugs:</h3>

Bugs are an unavoidable byproduct of any software development, and developers are always looking to remove them from their programs.

If you have experienced errors while using this program, or have been subject to unusual and/or unexpected behavior, please take the time to submit a bug report to:

- [forster.matth@gmail.com](mailto:forster.matth@gmail.com)

or if you have a Github Account:

- [LIIS Issues - GitHub](https://github.com/forstermatth/LIIS/issues)

<h3 id="about">About:</h3>

* #####Current Developers:
**Matt Forster ([@frostyforster][1])**
	* (under supervision of *Tim McAllister, Bob Forster*)
	* Lethbridge Research Center, University of Lethbridge Co-Op, 2013.

* #####Alpha development done by:
**Align Systems Design**
	* (*Matt Forster, David Sinclaire, Andrew Sanders, Graham Fluet*)
	* Computer Information Technology, Lethbridge College, 2013.

[1]: https://twitter.com/frostyforster



<hr>