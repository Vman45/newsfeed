* Still need to use the dom crawler to access actual newstory content, look for class or paragraph
 which have the summary, time say 30 characters then do .... a the end  
 
 * Chose to use helpers for api connection so can use on any url.  Dom was used for SlashDot and proved most challenging.
 
 * Decided to loop the return data and insert each row of records as I know this will work 
 but performance is not fast, but as this will run in background performance for user not a problem 
 
 * Would move db query into helper or reposity to keep the controller thin and function re use
 
 