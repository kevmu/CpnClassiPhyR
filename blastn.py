#!/usr/bin/python

import sys
import os
import re
import csv
import json
from Bio import SeqIO
from Bio.Seq import Seq
from subprocess import Popen, PIPE

blastn = '/usr/local/bin/blastn'
task = 'blastn'

cutadapt = '/usr/local/bin/cutadapt'

query_infile = "/Users/kmuirhead/Desktop/cpn60_UT_subgroups_data/CpnClassiPhyR/test_dataset/all_test_seqs.txt"
target_infile = "/Users/kmuirhead/Desktop/cpn60_UT_subgroups_data/CpnClassiPhyR/db/cpndb_nuc_phytoplasmas-2018-02-05.fasta"
print(query_infile)

clean_up_metadata = {}
for fasta_record in SeqIO.parse(query_infile, "fasta"):
    
    qseqid = str(fasta_record.id)
    qseq = str(fasta_record.seq)
    qalltitles = str(fasta_record.description)
    blastn_cmd = " ".join([blastn, "-query", '<(echo -e \">{}\\n{}\")'.format(qalltitles, qseq), "-db", target_infile, "-task", task, "-dust", "yes", "-max_target_seqs", "50", "-evalue", "1e-6", "-outfmt", "'6 qseqid salltitles qcovhsp pident length mismatch gapopen qstart qend sstart send sstrand evalue bitscore'"])
    print(blastn_cmd)
    p = Popen(blastn_cmd, stdout=PIPE, stderr=PIPE, shell=True, executable='/bin/bash')
    (blast_results, err) = p.communicate()
    p_status = p.wait()

    blast_output = blast_results.decode("utf-8")
    print(blast_output)
    print(err.decode("utf-8"))
    print(p_status)

    if(p_status == 0):
        is_phytoplasma = "false"
        best_hit = None
        blast_hit_list = blast_output.splitlines()
        for line in blast_hit_list:
            blast_hit = line.rstrip()
            blast_fields = blast_hit.split('\t')
            target_name = blast_fields[1]
    #        print(target_name)
            if(re.search('Phytoplasma', target_name)):
                best_hit = blast_fields
                align_length = int(best_hit[4])
                
#                print(align_length)
#                sys.exit()
                if((align_length >= 552) and (align_length <= 555)):
                    is_phytoplasma = "true"
                    break

        if(is_phytoplasma == "true"):
    #        print(best_hit)
            target_strand = best_hit[11]
    #        print(target_strand)
            if(target_strand == "plus"):
                print(target_strand)
                outfile = os.path.join("~/Desktop/cpn60_UT_subgroups_data/CpnClassiPhyR", "_".join([qseqid, "trimmed-sense.fasta"]))
                qseqrc = Seq(qseq).reverse_complement()
                cutadapt_cmd = " ".join([cutadapt, "-g", "H279p=GATNNNGCAGGNGATGGAACMACNAC", "-g", "D0317=GATNNNKCNGGNGAYGGNACNACNAC", "--format=fasta","-e", "0.04", "--no-indels", '<(echo -e \">{}\\n{}\")'.format(" ".join([qalltitles, "length=0 (+ strand)"]), qseq), "|", cutadapt, "-a", "H280p=AATGCNCCTGGTTTTGGNGANAAYCA", "-a", "D0318=GAWGCNCCWRGTTTTGGNGANMAYCA", "--format=fasta", "-e", "0.04", "--no-indels", "--length-tag 'length='", "-","-o", outfile])
                print(cutadapt_cmd)
                p = Popen(cutadapt_cmd, stdout=PIPE, stderr=PIPE, shell=True, executable='/bin/bash')
                (cutadapt_results, err) = p.communicate()
                p_status = p.wait()
                
                cutadapt_output = cutadapt_results.decode("utf-8")
                print(cutadapt_output)
                print(err.decode("utf-8"))
                print(p_status)
                clean_up_metadata[qseqid] = [qalltitles] + best_hit + ["Phytoplasma sequence (+ strand)"]
            elif(target_strand == "minus"):
#                print(target_strand)

                outfile = os.path.join("~/Desktop/cpn60_UT_subgroups_data/CpnClassiPhyR", "_".join([qseqid, "trimmed-sense.fasta"]))
                qseqrc = Seq(qseq).reverse_complement()
                cutadapt_cmd = " ".join([cutadapt, "-g", "H279p=GATNNNGCAGGNGATGGAACMACNAC", "-g", "D0317=GATNNNKCNGGNGAYGGNACNACNAC", "--format=fasta","-e", "0.04", "--no-indels", '<(echo -e \">{}\\n{}\")'.format(" ".join([qalltitles, "length=0 (+ strand)"]), qseqrc), "|", cutadapt, "-a", "H280p=AATGCNCCTGGTTTTGGNGANAAYCA", "-a", "D0318=GAWGCNCCWRGTTTTGGNGANMAYCA", "--format=fasta", "-e", "0.04", "--no-indels", "--length-tag 'length='", "-","-o", outfile])
                print(cutadapt_cmd)
                p = Popen(cutadapt_cmd, stdout=PIPE, stderr=PIPE, shell=True, executable='/bin/bash')
                (cutadapt_results, err) = p.communicate()
                p_status = p.wait()
                
                cutadapt_output = cutadapt_results.decode("utf-8")
                print(cutadapt_output)
                print(err.decode("utf-8"))
                print(p_status)
                clean_up_metadata[qseqid] = [qalltitles] + best_hit + ["Phytoplasma sequence (- strand)"]

        elif(is_phytoplasma == "false"):
            print("Not a phytoplasma sequence")
            print(blast_hit_list)
            clean_up_metadata[qseqid] = [qalltitles, "None", "Not a Phytoplasma sequence", "https://blast.ncbi.nlm.nih.gov/Blast.cgi?PROGRAM=blastn&PAGE_TYPE=BlastSearch&LINK_LOC=blasthome&QUERY=" + qseq]
            

    else:
        print(" ".join(["Error:", err.decode("utf-8"), "Process status:", str(p_status), "Command:"," ".join(blastn_cmd)]))
        sys.exit(1)

print(clean_up_metadata)
clean_up_metadata_outfile = os.path.join('/Users/kmuirhead/Desktop/cpn60_UT_subgroups_data/CpnClassiPhyR', 'clean_up_metadata.csv')
f = open(clean_up_metadata_outfile, 'w')
output_file = csv.writer(f)
for qseqid in clean_up_metadata:
    output_file.writerow([qseqid] + clean_up_metadata[qseqid])
f.close()
#subgroup_sc_matrix_infile = os.path.join('/Users/kmuirhead/Desktop/cpn60_UT_subgroups_data/CpnClassiPhyR','clean_up_metadata.json')
#subgroup_sc_matrix_file = open(subgroup_sc_matrix_infile, "w+")
#subgroup_sc_matrix_file.write(json.dumps(clean_up_metadata, indent=4))
#subgroup_sc_matrix_file.close()



##!/usr/bin/perl
#use warnings;
#use strict;
#use Getopt::Long;
#
#use File::Basename;
#use IPC::Open2;

## perl blastn.pl -d ~/workspace/GBS_data-08-10-2013/MPB_GBS_Data-08-10-2013/MPB_sequence_data/DendPond_male_1.0/Primary_Assembly/unplaced_scaffolds/FASTA/DendPond_male_1.0_unplaced.scaf.fa -i ~/gbs_sequences_clipped_Ns.fasta -t megablast -o ~/MPB_GBS_REFGEN_MEGABLAST_ALIGN -a 7
#my ($target_infile, $query_infile, $min_percent_id, $min_qcov, $blastn_task, $gap_open, $gap_extend, $num_descriptions, $num_alignments, $blast_num_cpu, $output_fmt, $output_dir);
#GetOptions(
#           'd=s'    => \$target_infile,
#           'i=s'    => \$query_infile,
#           'p=s'    => \$min_percent_id,
#           'c=s'    => \$min_qcov,
#           't=s'    => \$blastn_task,
#           'g=s'    => \$gap_open,
#           'e=s'    => \$gap_extend,
#           'v=s'    => \$num_descriptions,
#           'b=s'    => \$num_alignments,
#           'a=s'    => \$blast_num_cpu,
#           'f=s'    => \$output_fmt,
#           'o=s'    => \$output_dir,
#           );
#
#usage() unless (
#                defined $target_infile
#                and defined $query_infile
#                and defined $output_dir
#                );
#
#$min_qcov = 80 unless defined $min_qcov;
#
#$min_percent_id = 80 unless defined $min_percent_id;
#
#$blastn_task = 'blastn' unless defined $blastn_task;
#
#$gap_open = 5 unless defined $gap_open;
#
#$gap_extend = 2 unless defined $gap_extend;
#
#$num_descriptions = 25 unless defined $num_descriptions;
#
#$num_alignments = 25 unless defined $num_alignments;
#
#$blast_num_cpu = 2 unless defined $blast_num_cpu;
#
#$output_fmt = 'all' unless defined $output_fmt;
#
#my ($makeblastdb, $blastn);
#
## $makeblastdb 			= '/usr/bin/makeblastdb';
## $blastn				= '/usr/bin/blastn';
#
#$makeblastdb 			= '/usr/local/bin/makeblastdb';
#$blastn				= '/usr/local/bin/blastn';
#
#sub usage {
#
#die <<"USAGE";
#
#Usage: $0 -d target_infile -i query_infile -p min_percent_id -t blastn_task -g gap_open -e gap_extend -v num_descriptions -b num_alignments -a blast_num_cpu -f output_fmt -o output_dir
#
#Description -
#
#OPTIONS:
#    
#    -d target_infile -
#        
#        -i query_infile -
#            
#            -p min_percent_id
#                
#                -t blastn_task -
#                    
#                    -g gap_open - gap opening penalty (cost to open a gap).
#                        
#                        -e gap_extend - gap extension penalty (cost to extend a gap).
#                            
#                            -v num_descriptions -
#                                
#                                -b num_alignments -
#                                    
#                                    -a blast_num_cpu -
#                                        
#                                        -f output_fmt -
#                                            
#                                            -o output_dir -
#
#
#USAGE
#}
#
## Create output directory if it doesn't already exist.
#unless(-d $output_dir){
#    mkdir($output_dir, 0777) or die "Can't make directory: $!";
#}
#
#my $fasta_query_name = fileparse($query_infile);
#my $fasta_target_name = fileparse($target_infile);
#my $blastn_filename = join('/', $output_dir, join("_", $fasta_query_name, $fasta_target_name . ".$blastn_task"));
#
#my $blastn_infile = generate_blastn($query_infile, $target_infile, $blastn_task, $gap_open, $gap_extend, $num_descriptions, $num_alignments, $min_percent_id, $min_qcov, $blast_num_cpu, $output_fmt, $blastn_filename);
#
## makeblastdb -in ncbi_nr_db_2014-05-30_organisms.fasta -dbtype 'nucl' -out ncbi_nr_db_2014-05-30_organisms.fasta
#sub makeblastdb_nuc{
#    my $fastadb = shift;
#        die "Error lost fastadb to makeblastdb" unless defined $fastadb;
#            
#            # format the database file into .nin .nsq .nhr files.
#            my ($fastadbNIN, $fastadbNSQ, $fastadbNHR);
#                $fastadbNIN = $fastadb . '.nin';
#                    $fastadbNSQ = $fastadb . '.nsq';
#                        $fastadbNHR = $fastadb . '.nhr';
#                            unless(-s $fastadbNIN and -s $fastadbNSQ and -s $fastadbNHR){
#                                warn "Calling makeblastdb for $fastadb....\n";
#                                    warn "$makeblastdb -in $fastadb -dbtype nucl\n\n";
#                                        system($makeblastdb,
#                                               '-in', $fastadb,
#                                               '-dbtype', 'nucl'
#                                               ) == 0 or die "Error calling $makeblastdb -in $fastadb -dbtype nucl: $?";
#                                        }
#
#}
#
#sub generate_blastn{
#    
#    my $fasta_query = shift;
#        die "Error lost fasta query file" unless defined $fasta_query;
#        
#        my $fasta_target = shift;
#        die "Error lost fasta database target file" unless defined $fasta_target;
#        
#        my $blastn_task = shift;
#        die "Error lost blastn program task" unless defined $blastn_task;
#        
#        my $gap_open = shift;
#        die "Error lost gap opening penalty" unless defined $gap_open;
#        
#        my $gap_extend = shift;
#        die "Error lost gap extension penalty" unless defined $gap_extend;
#        
#        my $num_descriptions = shift;
#        die "Error lost number of descriptions" unless defined $num_descriptions;
#        
#        my $num_alignments = shift;
#        die "Error lost number of alignments" unless defined $num_alignments;
#        
#        my $min_percent_id = shift;
#        die "Error lost minimum percent identity" unless defined $min_percent_id;
#        
#        my $min_qcov = shift;
#        die "Error lost minimum query coverage" unless defined $min_qcov;
#        
#        my $blast_num_cpu = shift;
#        die "Error lost number of cpus to allocate" unless defined $blast_num_cpu;
#        
#        my $output_fmt = shift;
#        die "Error lost blastn output format" unless defined $output_fmt;
#        
#        my $blastn_filename = shift;
#        die "Error lost blastn output filename" unless defined $blastn_filename;
#        
#        makeblastdb_nuc($fasta_target);
#        
#        my $blastn_outfile;
#        if(($output_fmt eq 'tab') or ($output_fmt eq 'all')){
#            my $blastn_outfile = $blastn_filename . ".tsv.txt";
#                unless(-s $blastn_outfile){
#                    warn "Generating blastn tab-delimited file....\n";
#                        my $blastnCmd  = "$blastn -query $fasta_query -db $fasta_target -task $blastn_task -gapopen $gap_open -gapextend $gap_extend -dust yes -max_target_seqs $num_alignments -evalue 1e-6 -outfmt '6 qseqid salltitles qcovhsp pident length mismatch gapopen qstart qend sstart send evalue bitscore' -num_threads $blast_num_cpu";
#                        warn $blastnCmd . "\n\n";
#                        
#                        open(OUTFILE, ">$blastn_outfile") or die "Couldn't open file $blastn_outfile for writting, $!";
#                        print OUTFILE join("\t", "query_name", "target_name", "query_coverage", "percent_identity", "align_length", "num_mismatch",
#                                           "num_gaps", "query_start", "query_end", "target_start", "target_end", "e_value", "bit_score") . "\n";
#                                           local (*BLASTN_OUT, *BLASTN_IN);
#                                           my $pid = open2(\*BLASTN_OUT,\*BLASTN_IN, $blastnCmd) or die "Error calling open2: $!";
#                                           close BLASTN_IN or die "Error closing STDIN to blastn process: $!";
#                                           while(<BLASTN_OUT>){
#                                               chomp $_;
#                                                   my @blastn_hit =  split(/\t/, $_);
#                                                       my ($query_name, $target_name, $query_coverage, $percent_identity, $align_length, $num_mismatch,
#                                                           $num_gaps, $query_start, $query_end, $target_start, $target_end, $e_value, $bit_score) = @blastn_hit;
#                                                           if(($percent_identity >= $min_percent_id) and ($query_coverage >= $min_qcov)){
#                                                               $e_value = "< 1e-179" if ($e_value =~ m/0\.0/);
#                                                                   print OUTFILE join("\t", $query_name, $target_name, $query_coverage, $percent_identity, $align_length, $num_mismatch, 
#                                                                                      $num_gaps, $query_start, $query_end, $target_start, $target_end, $e_value, $bit_score) . "\n";
#                                                                   }
#                                                                                      }
#                    close BLASTN_OUT or die "Error closing STDOUT from blastn process: $!";
#                        wait;
#                        close(OUTFILE) or die "Couldn't close file $blastn_outfile";
#        }
#        
#        }
#        
#        if(($output_fmt eq 'align') or ($output_fmt eq 'all')){
#            my $blastn_outfile = $blastn_filename . ".aln.txt";
#                unless(-s $blastn_outfile){
#                    warn "Generating blastn alignment file....\n";
#                        my $blastnCmd  = "$blastn -query $fasta_query -db $fasta_target -task $blastn_task -gapopen $gap_open -gapextend $gap_extend -dust yes -num_descriptions $num_descriptions -num_alignments $num_alignments -evalue 1e-6 -out $blastn_outfile -num_threads $blast_num_cpu";
#                        warn $blastnCmd . "\n\n";
#                        
#                        my $status = system($blastn, 
#                                            '-query', $fasta_query,
#                                            '-db', $fasta_target,
#                                            '-task', $blastn_task,
#                                            '-gapopen', $gap_open,
#                                            '-gapextend', $gap_extend,
#                                            '-dust', 'yes',
#                                            '-num_descriptions', $num_descriptions,
#                                            '-num_alignments', $num_alignments,
#                                            '-evalue', 1e-6,
#                                            '-out', $blastn_outfile,
#                                            '-num_threads', $blast_num_cpu
#                                            ) == 0 or die "Error calling $blastn: $?";
#                
#        }
#}
#    return $blastn_outfile;
#}
