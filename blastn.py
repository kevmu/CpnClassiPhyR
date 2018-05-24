#!/usr/bin/python

import sys
import os
import argparse

import re
import csv
import json

from Bio import SeqIO
from Bio.Seq import Seq
from subprocess import Popen, PIPE

python_path = sys.argv[0]
app_dir = os.path.dirname(os.path.realpath(python_path))
sys.path.append(os.path.abspath(app_dir))

parser = argparse.ArgumentParser()

query_infile = None
output_dir = None

parser.add_argument('-i', action='store', dest='query_infile',
                    help='query fasta file as input. (i.e. filename.fasta)')
parser.add_argument('-o', action='store', dest='output_dir',
                    help='output directory as input. (i.e. $HOME)')

parser.add_argument('--version', action='version', version='%(prog)s 1.0')

results = parser.parse_args()

query_infile = results.query_infile
output_dir = results.output_dir

if(query_infile == None):
    print('\n')
    print('error: please use the -i option to specify the fasta query file as input')
    print('query_infile =' + ' ' + str(query_infile))
    print('\n')
    parser.print_help()
    sys.exit(1)
if(output_dir == None):
    print('\n')
    print('error: please use the -o option to specify the output directory as input')
    print('output_dir =' + ' ' + str(output_dir))
    print('\n')
    parser.print_help()
    sys.exit(1)


if not os.path.exists(output_dir):
    os.makedirs(output_dir)

#makeblastdb = '/usr/bin/makeblastdb';
makeblastdb = '/usr/local/ncbi/blast/bin/makeblastdb';
#blastn = '/usr/local/bin/blastn'
blastn = '/usr/local/ncbi/blast/bin/blastn'
cutadapt = '/usr/local/bin/cutadapt'

class CpnClassiPhyR():
    
    
    def __init__(self):
        #print("Initializing CpnClassiPhyR.....")
        
        # Restriction enzymes and restriction site sequences used in the insilico RFLP digests.
        self.renzymes = {
            'AluI': r'(AG)(CT)', # 'AluI': 'AG^CT', # pos 2
            'BfaI': r'(C)(TAG)', # 'BfaI': 'C^TAG', # pos 1
            # 'DraI': r'(TTT)(AAA)', # DraI: 'TTT^AAA', # pos 3
            #            'Bce3081I': r'(T)(AGGAG)', # 'Bce3081I': 'T^AGGAG', # pos 1
            #            'Cje263IV': r'([ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG]G)(AGTTTTGGT[ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG][ATCG])', # 'Cje263IV': 'G^AGTTTTGGT', # pos 1
            'HinfI': r'(G)(A[ATCG]TC)', # 'HinfI': 'G^ANTC', # pos 1
            'HpaI': r'(GTT)(AAC)', # 'HpaI': 'GTT^AAC', # pos 3
            'MseI': r'(T)(TAA)', # 'MseI': 'T^TAA', # pos 1
            'RsaI': r'(GT)(AC)', # 'RsaI': 'GT^AC', # pos 2
            'TaqI': r'(T)(CGA)' # 'TaqI': 'T^CGA', # pos 1
    }

    def makeblastdb_nuc(self, target_infile):

        fastadbNIN = target_infile + '.nin'
        fastadbNSQ = target_infile + '.nsq'
        fastadbNHR = target_infile + '.nhr'
        if(not(os.path.exists(fastadbNIN) and (os.path.getsize(fastadbNIN) > 0))
           and not(os.path.exists(fastadbNSQ) and (os.path.getsize(fastadbNSQ) > 0))
           and not(os.path.exists(fastadbNHR) and (os.path.getsize(fastadbNHR) > 0))):
            #warn "Calling makeblastdb for fastadb....\n";
            #warn "makeblastdb -in fastadb -dbtype nucl\n\n";
            os.system(makeblastdb +  ' ' + '-in' + ' ' + target_infile + ' ' + '-dbtype' + ' ' + 'nucl')


    def CpnIdentiPhyR(self, query_infile, target_infile, output_dir):
        self.makeblastdb_nuc(target_infile)

        clean_up_metadata = {}
        file_count = 1
        for fasta_record in SeqIO.parse(query_infile, "fasta"):
            
            qseqid = str(fasta_record.id)
            qseq = str(fasta_record.seq).upper()
            qalltitles = str(fasta_record.description)
            blastn_cmd = " ".join([blastn, "-query", '<(echo -e \">{}\\n{}\")'.format(qalltitles, qseq), "-db", target_infile, "-task", "blastn", "-dust", "yes", "-max_target_seqs", "50", "-evalue", "1e-6", "-outfmt", "'6 qseqid salltitles qcovhsp pident length mismatch gapopen qstart qend sstart send sstrand evalue bitscore'"])
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
                        percent_identity = float(best_hit[3])
                        #                print(align_length)
                        #                sys.exit()
                        if((align_length >= 552) and (align_length <= 555)):
                            is_phytoplasma = "true"
                            break
                    else:
                        best_hit = blast_fields
                        break


                if(is_phytoplasma == "true"):
                    #        print(best_hit)
                    target_strand = best_hit[11]
                    #        print(target_strand)
                    blastn_outfile = os.path.join(output_dir, "_".join([qseqid, str(file_count), "trimmed-sense.fasta"]))
                    if(target_strand == "plus"):
                        print(target_strand)
                        
                        qseqrc = Seq(qseq).reverse_complement()
                        cutadapt_cmd = " ".join([cutadapt, "-g", "H279p=GATNNNGCAGGNGATGGAACMACNACN", "-g", "D0317=GATNNNKCNGGNGAYGGNACNACNACN", "--format=fasta","-e", "0.04", "--no-indels", '<(echo -e \">{}\\n{}\")'.format(" ".join([qalltitles, "length=0 (+ strand)"]), qseq), "|", cutadapt, "-a", "H280p=AATGCNCCTGGTTTTGGNGANAAYCAN", "-a", "D0318=GAWGCNCCWRGTTTTGGNGANMAYCAN", "--format=fasta", "-e", "0.04", "--no-indels", "--length-tag 'length='", "-","-o", blastn_outfile])
                        print(cutadapt_cmd)
                        p = Popen(cutadapt_cmd, stdout=PIPE, stderr=PIPE, shell=True, executable='/bin/bash')
                        (cutadapt_results, err) = p.communicate()
                        p_status = p.wait()
                        
                        cutadapt_output = cutadapt_results.decode("utf-8")
                        print(cutadapt_output)
                        print(err.decode("utf-8"))
                        print(p_status)
                        clean_up_metadata["_".join([qseqid, str(file_count)])] = [qalltitles] + best_hit + ["Phytoplasma sequence (+ strand)"]
                    elif(target_strand == "minus"):
                        #                print(target_strand)
                        
                        qseqrc = Seq(qseq).reverse_complement()
                        cutadapt_cmd = " ".join([cutadapt, "-g", "H279p=GATNNNGCAGGNGATGGAACMACNACN", "-g", "D0317=GATNNNKCNGGNGAYGGNACNACNACN", "--format=fasta","-e", "0.04", "--no-indels", '<(echo -e \">{}\\n{}\")'.format(" ".join([qalltitles, "length=0 (+ strand)"]), qseqrc), "|", cutadapt, "-a", "H280p=AATGCNCCTGGTTTTGGNGANAAYCAN", "-a", "D0318=GAWGCNCCWRGTTTTGGNGANMAYCAN", "--format=fasta", "-e", "0.04", "--no-indels", "--length-tag 'length='", "-","-o", blastn_outfile])
                        print(cutadapt_cmd)
                        p = Popen(cutadapt_cmd, stdout=PIPE, stderr=PIPE, shell=True, executable='/bin/bash')
                        (cutadapt_results, err) = p.communicate()
                        p_status = p.wait()
                        
                        cutadapt_output = cutadapt_results.decode("utf-8")
                        print(cutadapt_output)
                        print(err.decode("utf-8"))
                        print(p_status)
                        clean_up_metadata["_".join([qseqid, str(file_count)])] = [qalltitles] + best_hit + ["Phytoplasma sequence (- strand)"]

                elif(is_phytoplasma == "false"):
                    print("Not a phytoplasma sequence")
                    print(blast_hit_list)
                    if(best_hit == None):
                        clean_up_metadata["_".join([qseqid, str(file_count)])] = [qalltitles, "None", "Not a Phytoplasma sequence"] + ['N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A'] + ["https://blast.ncbi.nlm.nih.gov/Blast.cgi?PROGRAM=blastn&PAGE_TYPE=BlastSearch&LINK_LOC=blasthome&QUERY=" + qseq]
                    else:
                        clean_up_metadata["_".join([qseqid, str(file_count)])] = [qalltitles, "None", "Not a Phytoplasma sequence"] + best_hit + ["https://blast.ncbi.nlm.nih.gov/Blast.cgi?PROGRAM=blastn&PAGE_TYPE=BlastSearch&LINK_LOC=blasthome&QUERY=" + qseq]


            else:
                print(" ".join(["Error:", err.decode("utf-8"), "Process status:", str(p_status), "Command:"," ".join(blastn_cmd)]))
                sys.exit(1)
            file_count = file_count + 1

        print(clean_up_metadata)

        clean_up_metadata_outfile = os.path.join(output_dir, 'clean_up_metadata.csv')

        f = open(clean_up_metadata_outfile, 'w')
        output_file = csv.writer(f)
        for qseqid in clean_up_metadata:
            output_file.writerow([qseqid] + clean_up_metadata[qseqid])
        f.close()
        #subgroup_sc_matrix_infile = os.path.join('/Users/kmuirhead/Desktop/cpn60_UT_subgroups_data/CpnClassiPhyR','clean_up_metadata.json')
        #subgroup_sc_matrix_file = open(subgroup_sc_matrix_infile, "w+")
        #subgroup_sc_matrix_file.write(json.dumps(clean_up_metadata, indent=4))
        #subgroup_sc_matrix_file.close()
        return output_file

#cpn_phytoplasma_primers = {
#    'H279p': 'GATNNNGCAGGNGATGGAACMACNACN',
#    'D0317': 'GATNNNKCNGGNGAYGGNACNACNACN',
#    'H280p': 'AATGCNCCTGGTTTTGGNGANAAYCAN',
#    'D0318': 'GAWGCNCCWRGTTTTGGNGANMAYCAN'
#}



target_infile = os.path.join(app_dir, 'db', 'cpndb_nuc_phytoplasmas-2018-02-05.fasta')

print(query_infile)

print(target_infile)

## Initialize CpnClassiPhyR
CpnClassiPhyR = CpnClassiPhyR()
clean_up_metadata_file = CpnClassiPhyR.CpnIdentiPhyR(query_infile, target_infile)


